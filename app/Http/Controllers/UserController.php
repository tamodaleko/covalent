<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\Company\Company;
use App\Models\User\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['profile', 'updateProfile', 'password', 'updatePassword']);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = [];
        $companyName = null;

        if ($request->company_id) {
            if ($request->company_id === 'no-company') {
                $companyName = 'No Company Selected';
                $users = User::where('company_id', null)->orderBy('first_name')->orderBy('last_name')->get();
            } else {
                $company = Company::find($request->company_id);
                $companyName = $company ? $company->name : null;
                $users = User::where('company_id', $request->company_id)->orderBy('first_name')->orderBy('last_name')->get();
            }
        }

        return view('users.index', [
            'users' => $users,
            'companyName' => $companyName
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\User\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);

        if (!$validated['is_admin'] && is_null($validated['company_id'])) {
            return redirect()->back()->withInput($validated)->withError('You have to choose a company.');
        }

        if (!$validated['is_admin'] && (!$request->has('folders') || !$request->folders)) {
            return redirect()->back()->withInput($validated)->withError('You have to choose a folder.');
        }

        if ($validated['is_admin']) {
            $validated['company_id'] = null;
        }

        $validated['verified'] = 1;

        $user = User::create($validated);

        if (!$user) {
            return redirect()->route('users.index')->withError('User could not be created.');
        }

        $user->updatePermissions($request->folders);

        $company_id = $user->company_id ?: 'no-company';

        return redirect()->route('users.index', ['company_id' => $company_id])->withSuccess('User has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'folders' => $user->company ? $user->company->getAllowedFolderStructure() : [],
            'selected' => $user->getAllowedFolders()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\UpdateUserRequest $request
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if (!$validated['is_admin'] && is_null($validated['company_id'])) {
            return redirect()->back()->withInput($validated)->withError('You have to choose a company.');
        }

        if (!$validated['is_admin'] && (!isset($validated['folders']) || !$validated['folders'])) {
            return redirect()->back()->withInput($validated)->withError('You have to choose a folder.');
        }

        if ($validated['is_admin']) {
            $validated['company_id'] = null;
        }

        $user->fill($validated);

        if (!$user->save()) {
            return redirect()->route('users.index')->withError('User could not be updated.');
        }

        $folders = !$validated['is_admin'] ? $request->folders : [];

        $user->updatePermissions($folders);

        $company_id = $user->company_id ?: 'no-company';

        return redirect()->route('users.index', ['company_id' => $company_id])->withSuccess('User has been updated successfully.');
    }

    /**
     * Show the form for user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('users.profile')->withUser(auth()->user());
    }

    /**
     * Update the user profile.
     *
     * @param \App\Http\Requests\User\UpdateUserProfileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $user = auth()->user()->edit($request->validated(), $request->file('avatar'));

        if (!$user) {
            return redirect()->route('users.profile')->withError('Profile could not be updated.');
        }

        return redirect()->route('users.profile')->withSuccess('Profile has been updated successfully.');
    }

    /**
     * Show the form for changing user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('users.password');
    }

    /**
     * Update the user password.
     *
     * @param \App\Http\Requests\User\UpdateUserPasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdateUserPasswordRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();

        if (!password_verify($validated['current_password'], $user->password)) {
            return redirect()->route('users.password')->withError('Current password is invalid.');
        }

        $user->password = bcrypt($validated['new_password']);

        if (!$user->save()) {
            return redirect()->route('users.password')->withError('Password could not be updated.');
        }

        return redirect()->route('users.password')->withSuccess('Password has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$user->delete()) {
            return redirect()->route('users.index')->withError('User could not be deleted.');
        }

        return redirect()->route('users.index')->withSuccess('User has been deleted successfully.');
    }
}
