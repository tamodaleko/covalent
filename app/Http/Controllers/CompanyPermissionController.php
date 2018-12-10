<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\UpdateCompanyPermissionsRequest;
use App\Models\Company\Company;
use App\Models\Folder;

class CompanyPermissionController extends Controller
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
        return view('companies.permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.permissions.edit', [
            'company' => $company,
            'folders' => Folder::getFullStructure(),
            'selected' => $company->getAllowedFolders()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Company\UpdateCompanyPermissionsRequest $request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyPermissionsRequest $request, Company $company)
    {
        if (!$company->updatePermissions($request->input('folders'))) {
            return redirect()->back()->withError('Company permissions could not be updated.');
        }

        return redirect()->back()->withSuccess('Company permissions have been updated successfully.');
    }
}
