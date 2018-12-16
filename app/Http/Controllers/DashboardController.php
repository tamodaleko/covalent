<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id = $request->session()->get('company_id');
        $search = $request->get('search');

        if (auth()->user()->is_admin) {
            if ($company_id && !$request->company_id) {
                $company = Company::find($company_id);
            } else {
                $company = Company::find($request->company_id);
            }

            if ($request->company_id) {
                $request->session()->put('company_id', $request->company_id);
            }

            $folders = $company ? $company->getAllowedFolderStructure($search) : [];
        } else {
            $company = auth()->user()->company;
            $folders = $company ? auth()->user()->getAllowedFolderStructure($search) : [];
        }

        return view('dashboard.index', [
            'company' => $company,
            'folders' => $folders
        ]);
    }
}
