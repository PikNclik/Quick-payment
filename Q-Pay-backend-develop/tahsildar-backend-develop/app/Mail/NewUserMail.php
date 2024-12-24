<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    private $userPayload;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userPayload)
    {
        $this->userPayload = $userPayload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New User Created')
            ->view('mails.new_user_mail',['user'=>$this->userPayload]);
    }
}
