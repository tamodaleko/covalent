<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivateUser;
use App\Models\User\User;
use App\Models\User\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display thank you page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function thanks(Request $request)
    {
        return view('auth.thanks');
    }

    /**
     * Verify user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $verification = UserVerification::where('token', $request->token)->first();

        if ($verification && $verification->user) {
            $verification->user->verified = 1;
            $verification->user->save();

            $verification->used = 1;
            $verification->save();

            $admins = User::where('is_admin', 1)->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ActivateUser($verification->user));
            }

            $result = true;
        } else {
            $result = false;
        }

        return view('auth.verify', ['result' => $result]);
    }
}
