<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\CopyFileRequest;
use App\Http\Requests\File\DeleteFilesRequest;
use App\Http\Requests\File\DownloadFilesRequest;
use App\Http\Requests\File\MoveFileRequest;
use App\Http\Requests\File\RenameFileRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\AmazonS3Service;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $responseJson = new \stdClass();
        $files = $request->file('files');

        foreach ($files as $file) {
            $clientName = $file->getClientOriginalName();

            $name = pathinfo($clientName, PATHINFO_FILENAME);
            $extension = pathinfo($clientName, PATHINFO_EXTENSION);

            $fileService = new FileService($file);

            $folder = Folder::find($request->folder_id);
            $filename = File::getValidName($folder->id, $name, $extension);

            $response = [
                'name' => $clientName,
                'size' => $file->getClientSize()
            ];

            if (!$fileService->uploadToS3($folder->getPath(), $filename . '.' . $extension)) {
                $response['error'] = 'The file could not be uploaded.';
            } else {
                $fileRecord = File::create([
                    'folder_id' => $request->folder_id,
                    'name' => $filename,
                    'extension' => $extension,
                    'size' => $file->getClientSize()
                ]);

                $response['thumbnailUrl'] = $fileRecord->isViewable() ? $fileRecord->getLink() : '';
                $response['url'] = $fileRecord->getLink(true);
                $response['folder_id'] = $folder->id;
                $response['html'] = view('partials.file', ['file' => $fileRecord, 'search' => false])->render();
            }

            $responseJson->files[] = $response;
        }

        return response()->json($responseJson);
    }

    /**
     * Rename file.
     *
     * @param \App\Http\Requests\File\RenameFileRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function rename(RenameFileRequest $request, File $file)
    {
        $check = File::where([
            'folder_id' => $file->folder_id,
            'name' => $request->name,
            'extension' => $file->extension
        ])->first();

        if ($check) {
            return redirect()->back()->withError('File with selected name already exists in folder.');
        }

        $sourceName = $file->fullName;
        $file->name = $request->name;

        if (!$file->save()) {
            return redirect()->back()->withError('File could not be renamed.');
        }

        $sourcePath = $file->folder->getPath() . '/' . $sourceName;
        $targetPath = $file->folder->getPath() . '/' . $file->fullName;

        (new AmazonS3Service())->moveFile($sourcePath, $targetPath);

        return redirect()->back()->withSuccess('File has been renamed successfully.');
    }

    /**
     * Copy file.
     *
     * @param \App\Http\Requests\File\CopyFileRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function copy(CopyFileRequest $request, File $file)
    {
        $copy = $file->createCopy($request->folder_id);

        if (!$copy) {
            return redirect()->back()->withError('File could not be copied.');
        }

        $sourcePath = $file->folder->getPath() . '/' . $file->fullName;
        $targetPath = $copy->folder->getPath() . '/' . $copy->fullName;

        (new AmazonS3Service())->copyFile($sourcePath, $targetPath);

        return redirect()->back()->withSuccess('File has been copied successfully.');
    }

    /**
     * Move file.
     *
     * @param \App\Http\Requests\File\MoveFileRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function move(MoveFileRequest $request, File $file)
    {
        if ($file->folder_id == $request->folder_id) {
            return redirect()->back()->withError('File could not be moved.');
        }

        $oldPath = $file->folder->getPath();
        $oldName = $file->fullName;

        $file->folder_id = $request->folder_id;
        $file->name = File::getValidName($file->folder_id, $file->name, $file->extension);

        if (!$file->save()) {
            return redirect()->back()->withError('File could not be moved.');
        }

        $file->load('folder');

        $sourcePath = $oldPath . '/' . $oldName;
        $targetPath = $file->folder->getPath() . '/' . $file->fullName;

        (new AmazonS3Service())->moveFile($sourcePath, $targetPath);

        return redirect()->back()->withSuccess('File has been moved successfully.');
    }

    /**
     * Download file.
     *
     * @param \App\Http\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function download(File $file)
    {
        $tempFile = tempnam(sys_get_temp_dir(), $file->fullName);
        copy($file->getLink(true), $tempFile);

        return response()->download($tempFile, $file->fullName);
    }

    /**
     * Download multiple files.
     *
     * @param \App\Http\Requests\File\DownloadFilesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function downloadMultiple(DownloadFilesRequest $request)
    {
        $files = File::whereIn('id', $request->post('files'))->get();
        $dir = 'uploads/zips/files_' . time() . '.zip';

        $zip = new \ZipArchive();
        $zip->open($dir, \ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip->addFromString($file->fullName, file_get_contents($file->getLink(true)));
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip'
        ];

        if (file_exists($dir)) {
            return response()->download($dir, 'files.zip', $headers);
        }

        return redirect()->back();
    }

    /**
     * Delete multiple files.
     *
     * @param \App\Http\Requests\File\DeleteFilesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(DeleteFilesRequest $request)
    {
        $delete = File::whereIn('id', $request->post('files'))->delete();

        if (!$delete) {
            return redirect()->back()->withError('Files could not be deleted.');
        }

        return redirect()->back()->withSuccess('Files have been deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $path = $file->folder->getPath() . '/' . $file->fullName;

        if (!$file->delete()) {
            return redirect()->back()->withError('File could not be deleted.');
        }

        (new AmazonS3Service())->deleteFile($path);

        return redirect()->back()->withSuccess('File has been deleted successfully.');
    }
}
