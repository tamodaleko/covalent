<?php

namespace App\Http\Controllers;

use AWS;
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

        // $s3 = AWS::createClient('s3');

        // try {
        //     $result = $s3->listObjects(['Bucket' => 'cybernext']);
        // } catch (Aws\S3\Exception\S3Exception $e) {
        //     echo $e->getMessage();
        // }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->company_id && auth()->user()->is_admin) {
            $company = Company::find($request->company_id);
        } else {
            $company = auth()->user()->company;
        }

        $folders = $company ? $company->getFolderStructure() : [];

        return view('dashboard.index')->withFolders($folders);
    }
}
