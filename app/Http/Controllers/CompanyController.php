<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Requests\Company\UsersNotifyRequest;
use App\Models\Company\Company;
use App\Models\Folder;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        return view('companies.create', [
            'folders' => Folder::getStructure()
        ]);
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
        $company->updatePermissions($request->folders, false);

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
            'selected' => $company->getAllowedFolders(),
            'users' => $company->users()->pluck('id')->toArray()
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
        $company->updateUsers($request->users);
        $company->updatePermissions($request->folders);
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

    /**
     * Get users ajax.
     *
     * @param \Illuminate\Http\Request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, Company $company)
    {
        $result = [];

        foreach ($company->users as $user) {
            $result['users'][] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        }

        return response()->json($result);
    }

    /**
     * Get folders ajax.
     *
     * @param \Illuminate\Http\Request
     * @param \App\Models\Company\Company $company
     * @return \Illuminate\Http\Response
     */
    public function folders(Request $request, Company $company)
    {
        $folders = $company->getAllowedFolderStructure();

        if (!$folders) {
            return null;
        }

        $user = User::find($request->user_id);

        return view('partials.permissions.folders_ajax', [
            'folders' => $folders,
            'selected' => $user ? $user->getAllowedFolders() : []
        ]);
    }

    /**
     * Get folders for copy ajax.
     *
     * @param \App\Models\Company\Company $company
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function foldersCopy(Company $company, Folder $folder)
    {
        return response()->json($company->getFoldersForCopy($folder));
    }

    /**
     * Get folders for move ajax.
     *
     * @param \App\Models\Company\Company $company
     * @param \App\Models\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function foldersMove(Company $company, Folder $folder)
    {
        return response()->json($company->getFoldersForMove($folder));
    }

    /**
     * Notify Users.
     *
     * @param \App\Http\Requests\Company\UsersNotifyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function usersNotify(UsersNotifyRequest $request)
    {
        $users = User::find($request->users);

        foreach ($users as $user) {
            Mail::send([], [], function ($message) use ($request, $user) {
                $message->to($user->email)
                    ->subject($request->subject)
                    ->setBody($request->message, 'text/html');
            });
        }

        return redirect()->back()->withSuccess('Users have been notified successfully.');
    }
}
