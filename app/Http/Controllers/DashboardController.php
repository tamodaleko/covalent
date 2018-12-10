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
        if (auth()->user()->is_admin) {
            $company = Company::find($request->company_id);
        } else {
            $company = auth()->user()->company;
        }

        return view('dashboard.index', [
            'company' => $company,
            'folders' => $company ? $company->getFolderStructure() : []
        ]);
    }
}
