<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\DownloadFilesRequest;
use App\Http\Requests\File\MoveFileRequest;
use App\Http\Requests\File\StoreFileRequest;
use App\Models\File;
use App\Models\Folder;
use App\Services\AmazonS3Service;
use App\Services\FileService;

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
     * @param \App\Http\Requests\File\StoreFileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        $fileService = new FileService($file);

        $folder = Folder::find($request->folder_id);

        if (!$fileService->uploadToS3($folder->getPath(), $filename)) {
            return redirect()->back()->withError('File could not be uploaded.');
        }

        File::create([
            'folder_id' => $request->folder_id,
            'name' => pathinfo($filename, PATHINFO_FILENAME),
            'extension' =>  pathinfo($filename, PATHINFO_EXTENSION),
            'size' => $file->getClientSize()
        ]);

        return redirect()->back()->withSuccess('File has been uploaded successfully.');
    }

    /**
     * Download selected files.
     *
     * @param \App\Http\Requests\File\DownloadFilesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function download(DownloadFilesRequest $request)
    {
        $files = File::whereIn('id', $request->post('files'))->get();
        $dir = public_path() . DIRECTORY_SEPARATOR . 'uploads/zips/files_' . time() . '.zip';

        $zip = new \ZipArchive();
        $zip->open($dir, \ZipArchive::CREATE);

        foreach ($files as $file) {
            $link = str_replace(' ', '%20', $file->getLink());
            $zip->addFromString($file->fullName, file_get_contents($link));
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
     * Move file.
     *
     * @param \App\Http\Requests\File\MoveFileRequest $request
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function move(MoveFileRequest $request, File $file)
    {
        $oldPath = $file->folder->getPath();
        $file->folder_id = $request->validated()['folder_id'];

        if (!$file->save()) {
            return redirect()->back()->withError('File could not be moved.');
        }

        $file->load('folder');

        $sourcePath = $oldPath . '/' . $file->fullName;
        $targetPath = $file->folder->getPath() . '/' . $file->fullName;

        (new AmazonS3Service())->moveFile($sourcePath, $targetPath);

        return redirect()->back()->withSuccess('File has been moved successfully.');
    }

    /**
     * Copy file.
     *
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function copy(File $file)
    {
        $copy = $file->createCopy();

        if (!$copy) {
            return redirect()->back()->withError('File could not be copied.');
        }

        $sourcePath = $file->folder->getPath() . '/' . $file->fullName;
        $targetPath = $copy->folder->getPath() . '/' . $copy->fullName;

        (new AmazonS3Service())->copyFile($sourcePath, $targetPath);

        return redirect()->back()->withSuccess('File has been copied successfully.');
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
