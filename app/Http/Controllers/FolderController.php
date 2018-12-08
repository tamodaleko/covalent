<?php

namespace App\Http\Controllers;

use App\Http\Requests\Folder\StoreFolderRequest;
use App\Http\Requests\Folder\UpdateFolderStatusRequest;
use App\Http\Requests\Folder\UpdateFolderTagRequest;
use App\Models\Folder;

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
        $folder = Folder::create($request->validated());

        if (!$folder) {
            return redirect()->back()->withError('Folder could not be created.');
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
        if (!$folder->delete()) {
            return redirect()->back()->withError('Folder could not be deleted.');
        }

        return redirect()->back()->withSuccess('Folder has been deleted successfully.');
    }
}
