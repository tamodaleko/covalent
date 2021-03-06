<?php

namespace App\Mail;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User\User
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User\User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.auth.verify')
            ->with([
                'name' => $this->user->first_name,
                'email' => $this->user->email,
                'token' => $this->user->verification->token
            ]);
    }
}
