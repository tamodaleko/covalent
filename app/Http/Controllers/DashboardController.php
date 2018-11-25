<?php

namespace App\Http\Controllers;

use AWS;
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
    public function index()
    {
        // $s3 = AWS::createClient('s3');

        // try {
        //     $result = $s3->listObjects(['Bucket' => 'cybernext']);
        // } catch (Aws\S3\Exception\S3Exception $e) {
        //     echo $e->getMessage();
        // }

        return view('dashboard.index');
    }
}
