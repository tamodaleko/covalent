<?php

namespace App\Http\Controllers;

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
