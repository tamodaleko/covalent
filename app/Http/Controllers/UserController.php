<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\User\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['profile', 'updateProfile']);
        $this->middleware('auth')->only(['profile', 'updateProfile']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::all()
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

        $user = User::create($validated);

        if (!$user) {
            return redirect()->route('users.index')->withError('User could not be created.');
        }

        $user->grantDefaultPermissions();

        return redirect()->route('users.index')->withSuccess('User has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')->withUser($user);
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

        $user->fill($validated);

        if (!$user->save()) {
            return redirect()->route('users.index')->withError('User could not be updated.');
        }

        return redirect()->route('users.index')->withSuccess('User has been updated successfully.');
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
        $validated = $request->validated();

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user = auth()->user()->edit($validated, $request->file('avatar'));

        if (!$user) {
            return redirect()->back()->withError('Profile could not be updated.');
        }

        return redirect()->back()->withSuccess('Profile has been updated successfully.');
    }
}
