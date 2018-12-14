<?php

namespace App\Http\Controllers;

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
            $folder->attachToUser(auth()->user()->id);
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
