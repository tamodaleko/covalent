<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company\Company;
use App\Models\Folder;

class CompanyController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index', [
            'companies' => Company::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Company\StoreCompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::add($request->validated(), $request->file('logo'));

        if (!$company) {
            return redirect()->route('companies.index')->withError('Company could not be created.');
        }

        Folder::addForCompany($company->name, $company->id);

        return redirect()->route('companies.index')->withSuccess('Company has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', [
            'company' => $company,
            'folders' => Folder::getStructure(),
            'selected' => $company->getAllowedFolders()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Company\UpdateCompanyRequest $request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->updatePermissions($request->input('folders'));
        $company = $company->edit($request->validated(), $request->file('logo'));

        if (!$company) {
            return redirect()->route('companies.index')->withError('Company could not be updated.');
        }

        return redirect()->route('companies.index')->withSuccess('Company has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if (!$company->delete()) {
            return redirect()->route('companies.index')->withError('Company could not be deleted.');
        }

        return redirect()->route('companies.index')->withSuccess('Company has been deleted successfully.');
    }
}
