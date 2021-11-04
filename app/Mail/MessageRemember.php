<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageRemember extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'AGENDAMIENTO DE VISITA - COLCHILDREN';

    public $datesMail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datesMail)
    {
        $this->datesMail = $datesMail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('modules.customers.mailsLetter');
    }
}
