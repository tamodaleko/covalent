<?php

namespace App\Http\Controllers;

use App\Http\Requests\Folder\CopyFolderRequest;
use App\Http\Requests\Folder\MoveFolderRequest;
use App\Http\Requests\Folder\StoreFolderRequest;
use App\Http\Requests\Folder\UpdateFolderStatusRequest;
use App\Http\Requests\Folder\UpdateFolderTagRequest;
use App\Models\Folder;
use App\Services\AmazonS3Service;

class FolderController extends Controller
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
     * @param \App\Http\Requests\Folder\StoreFolderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request)
    {
        $validated = $request->validated();

        $folder = Folder::addForCompany(
            $validated['name'],
            $validated['company_id'],
            $validated['parent_folder_id']
        );

        if (!$folder) {
            return redirect()->back()->withError('Folder could not be created.');
        }

        if (!auth()->user()->is_admin) {
            Folder::attachToUser($folder->id, auth()->user()->id);
        }

        return redirect()->back()->withSuccess('Folder has been created successfully.');
    }

    /**
     * Update folder status.
     *
     * @param \App\Http\Requests\Folder\UpdateFolderStatusRequest $request
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(UpdateFolderStatusRequest $request, Folder $folder)
    {
        $folder->fill($request->validated());

        if (!$folder->save()) {
            return redirect()->back()->withError('Folder status could not be updated.');
        }

        return redirect()->back()->withSuccess('Folder status has been updated successfully.');
    }

    /**
     * Update folder tag.
     *
     * @param \App\Http\Requests\Folder\UpdateFolderTagRequest $request
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function updateTag(UpdateFolderTagRequest $request, Folder $folder)
    {
        $folder->fill($request->validated());

        if (!$folder->save()) {
            return redirect()->back()->withError('Folder tag could not be updated.');
        }

        return redirect()->back()->withSuccess('Folder tag has been updated successfully.');
    }

    /**
     * Copy folder.
     *
     * @param \App\Http\Requests\Folder\CopyFolderRequest $request
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function copy(CopyFolderRequest $request, Folder $folder)
    {
        $copy = $folder->createCopy($request->parent_folder_id);

        if (!$copy) {
            return redirect()->back()->withError('Folder could not be copied.');
        }

        $files = $folder->replicateSubFolders($copy->id);

        if ($files) {
            (new AmazonS3Service())->copyFiles($files);
        }

        return redirect()->back()->withSuccess('Folder has been copied successfully.');
    }

    /**
     * Move folder.
     *
     * @param \App\Http\Requests\Folder\MoveFolderRequest $request
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function move(MoveFolderRequest $request, Folder $folder)
    {
        if ($folder->parent_folder_id == $request->parent_folder_id) {
            return redirect()->back()->withError('Folder could not be moved.');
        }

        $sourceFiles = $folder->getFilesPath();

        $folder->parent_folder_id = $request->parent_folder_id;
        $folder->name = Folder::getValidName($folder->parent_folder_id, $folder->name);

        if (!$folder->save()) {
            return redirect()->back()->withError('Folder could not be moved.');
        }

        $folder->load('subFolders');
        $folder->load('files');
        
        $targetFiles = $folder->getFilesPath();
        $files = [];

        foreach ($targetFiles as $k => $value) {
            $files[$k] = [
                'sourcePath' => $sourceFiles[$k]['path'],
                'targetPath' => $value['path']
            ];
        }

        if ($files) {
            (new AmazonS3Service())->moveFiles($files);
        }

        return redirect()->back()->withSuccess('Folder has been moved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $path = $folder->getPath() . '/';

        if (!$folder->delete()) {
            return redirect()->back()->withError('Folder could not be deleted.');
        }

        (new AmazonS3Service())->deleteFolder($path);

        return redirect()->back()->withSuccess('Folder has been deleted successfully.');
    }
}
