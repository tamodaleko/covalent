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

        if ($search) {
            return $this->search($request);
        }

        if (auth()->user()->is_admin) {
            if ($company_id && !$request->company_id) {
                $company = Company::find($company_id);
            } else {
                $company = Company::find($request->company_id);
            }

            if ($request->company_id) {
                $request->session()->put('company_id', $request->company_id);
            }

            $folders = $company ? $company->getAllowedFolderStructure() : [];
        } else {
            $company = auth()->user()->company;
            $folders = $company ? auth()->user()->getAllowedFolderStructure() : [];
        }

        return view('dashboard.index', [
            'company' => $company,
            'folders' => $folders
        ]);
    }

    /**
     * Show the file search results.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        if (auth()->user()->is_admin) {
            $company = Company::find($request->session()->get('company_id'));
            $files = $company ? $company->getAllowedFileSearch($search) : [];
        } else {
            $company = auth()->user()->company;
            $files = $company ? auth()->user()->getAllowedFileSearch($search) : [];
        }

        return view('dashboard.search', [
            'company' => $company,
            'files' => $files
        ]);
    }
}
