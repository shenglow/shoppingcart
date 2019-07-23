<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $username;
    private $randomPassword;

    /**
     * Create a new message instance.
     *
     * @param string $randomPassword
     * 
     * @return void
     */
    public function __construct($username, $randomPassword)
    {
        $this->username = $username;
        $this->randomPassword = $randomPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgot-password')
                    ->with([
                        'username' => $this->username,
                        'randomPassword' => $this->randomPassword
                    ]);
    }
}
