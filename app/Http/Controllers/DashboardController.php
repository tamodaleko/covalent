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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('search')) {
            return $this->search($request);
        }

        $user = auth()->user();

        if ($user->is_admin) {
            $company_id = $request->session()->get('company_id');

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
            $company = $user->company;
            $folders = $company ? $user->getAllowedFolderStructure() : [];
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
        $user = auth()->user();

        if ($user->is_admin) {
            $company = Company::find($request->session()->get('company_id'));
            $files = $company ? $company->getAllowedFileSearch($search) : [];
        } else {
            $company = $user->company;
            $files = $company ? $user->getAllowedFileSearch($search) : [];
        }

        return view('dashboard.search', [
            'company' => $company,
            'files' => $files
        ]);
    }
}
