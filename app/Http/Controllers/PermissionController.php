<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\UpdatePermissionsRequest;
use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Http\Request;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id = $request->session()->get('company_id');

        if ($company_id) {
            return redirect()->route('permissions.edit', ['company_id' => $company_id]);
        }

        return view('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Company $company)
    {
        $request->session()->put('company_id', $company->id);

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
            $user->updatePermissions($request->folders);
        }

        return redirect()->back()->withSuccess('Permissions have been granted successfully.');
    }
}
