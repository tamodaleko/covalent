<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $company = Company::create($request->validated());

        if (!$company) {
            return redirect()->route('companies.index')->withError('Company could not be created.');
        }

        $image = $request->file('logo');
        $name = Auth::user()->id . '_' . time() . '.' . $image->getClientOriginalExtension();

        try {
            $image->move('uploads/images/companies', $name);
        } catch (\Exception $e) {
            $company->delete();
            return redirect()->route('companies.index')->withError('Company could not be created.');
        }

        $company->logo = $name;
        $company->save();

        return redirect()->route('companies.index')->withSuccess('Company has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit')->withCompany($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Company\UpdateCompanyRequest $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->fill($request->validated());

        if (!$company->save()) {
            return redirect()->route('companies.index')->withError('Company could not be updated.');
        }

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = Auth::user()->id . '_' . time() . '.' . $image->getClientOriginalExtension();

            try {
                $image->move('uploads/images/companies', $name);
            } catch (\Exception $e) {
                $company->delete();
                return redirect()->route('companies.index')->withError('Company could not be updated.');
            }

            $company->logo = $name;
            $company->save();
        }

        return redirect()->route('companies.index')->withSuccess('Company has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
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
