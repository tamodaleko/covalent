<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserPermissionsRequest;
use App\Models\User\User;

class UserPermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.permissions.edit', [
            'user' => $user,
            'folders' => $user->company ? $user->company->getAllowedFolderStructure() : [],
            'selected' => $user->getAllowedFolders()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\UpdateUserPermissionsRequest $request
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPermissionsRequest $request, User $user)
    {
        if (!$user->updatePermissions($request->folders)) {
            return redirect()->back()->withError('User permissions could not be updated.');
        }

        return redirect()->back()->withSuccess('User permissions have been updated successfully.');
    }
}
