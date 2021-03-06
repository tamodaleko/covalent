<?php

namespace App\Http\Controllers;

use App\Http\Requests\Folder\CopyFolderRequest;
use App\Http\Requests\Folder\CreateFolderRequest;
use App\Http\Requests\Folder\MoveFolderRequest;
use App\Http\Requests\Folder\RenameFolderRequest;
use App\Http\Requests\Folder\StoreFolderRequest;
use App\Http\Requests\Folder\UpdateFolderStatusRequest;
use App\Http\Requests\Folder\UpdateFolderTagRequest;
use App\Models\Folder;
use App\Services\AmazonS3Service;
use Illuminate\Http\Request;

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

        $notUnique = Folder::where([
            'parent_folder_id' => $validated['parent_folder_id'],
            'name' => $validated['name']
        ])->first();

        if ($notUnique) {
            return redirect()->back()->withError('Folder name is already taken within selected folder.');
        }

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
     * Create new folder.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $parent_folder_id = $request->parent_folder_id;
        $name = $request->name;

        if (!$name) {
            return response()->json([
                'success' => false,
                'message' => 'Folder name is required.'
            ], 200);
        }

        $notUnique = Folder::where([
            'parent_folder_id' => $parent_folder_id,
            'name' => $name
        ])->first();

        if ($notUnique) {
            return response()->json([
                'success' => false,
                'message' => 'Folder name is already taken within selected folder.'
            ], 200);
        }

        $folder = Folder::create([
            'parent_folder_id' => $parent_folder_id,
            'name' => $name
        ]);

        if (!$folder) {
            return response()->json([
                'success' => false,
                'message' => 'Folder could not be created.'
            ], 200);
        }

        if ($request->company_id) {
            Folder::attachToCompany($folder->id, $request->company_id);
        }

        $folder->subFolders = [];

        if (!$folder->parent_folder_id) {
            $html = view('partials.permissions.folders', ['folder' => $folder, 'selected' => []])->render();
        } else {
            $html = view('partials.permissions.sub_folders', ['folder' => $folder, 'selected' => []])->render(); 
        }

        return response()->json([
            'success' => true,
            'message' => 'Folder has been created successfully.',
            'html' => $html
        ], 200);
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
     * Rename folder.
     *
     * @param \App\Http\Requests\Folder\RenameFolderRequest $request
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function rename(RenameFolderRequest $request, Folder $folder)
    {
        $check = Folder::where([
            'parent_folder_id' => $folder->parent_folder_id,
            'name' => $request->name
        ])->first();

        if ($check) {
            return redirect()->back()->withError('Folder with selected name already exists within path.');
        }

        $sourceFiles = $folder->getFilesPath();
        $folder->name = $request->name;

        if (!$folder->save()) {
            return redirect()->back()->withError('Folder could not be renamed.');
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

        return redirect()->back()->withSuccess('Folder has been renamed successfully.');
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
