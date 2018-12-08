<?php

namespace App\Http\Controllers;

use AWS;
use App\Http\Requests\File\StoreFileRequest;
use App\Models\File;

class FileController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\File\StoreFileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();

        try {
            $file->move('uploads/files', $filename);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }

        $s3 = AWS::createClient('s3');

        try {
            $result = $s3->putObject([
                'Bucket' => 'cybernext',
                'Key' => '/test-dejan/' . $filename,
                'Body' => fopen('uploads/files/' . $filename, 'r'),
                'ACL' => 'public-read'
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            return redirect()->back()->withError('File could not be uploaded.');
        }

        dd($result);

        if (!$user) {
            return redirect()->route('users.index')->withError('User could not be created.');
        }

        return redirect()->back()->withSuccess('File has been uploaded successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\UpdateUserRequest $request
     * @param \App\Models\User $user
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
     * @param \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        if (!$file->delete()) {
            return redirect()->route('dashboard.index')->withError('File could not be deleted.');
        }

        return redirect()->route('dashboard.index')->withSuccess('File has been deleted successfully.');
    }
}
