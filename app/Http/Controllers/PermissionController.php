<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\UpdatePermissionsRequest;
use App\Models\Company\Company;
use App\Models\User\User;

class PermissionController extends Controller
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
     * Display a index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('permissions.edit', [
            'company' => $company,
            'users' => $company->users,
            'folders' => $company->getAllowedFolderStructure()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Permission\UpdatePermissionsRequest $request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionsRequest $request, Company $company)
    {
        $users = User::find($request->users);

        foreach ($users as $user) {
            $user->addPermissions($request->folders);
        }

        return redirect()->back()->withSuccess('Permissions have been granted successfully.');
    }
}
