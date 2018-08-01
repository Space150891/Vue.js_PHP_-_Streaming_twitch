<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\MainContent;

class WellcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $content = MainContent::where('name', 'welcomeEmail')->first();
        $this->mailText = $content ? $content->content : 'Welcome to Gamificator!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.wellcome', ['text' => $this->mailText]);
    }
}
