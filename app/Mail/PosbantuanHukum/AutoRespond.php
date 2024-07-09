<?php

namespace App\Mail\PosbantuanHukum;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AutoRespond extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $namalengkap;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $namalengkap)
    {
        $this->user = $user;
        $this->namalengkap = $namalengkap;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pos Bantuan Hukum ' . $this->user->username)
                    ->view('emails.posbantuanhukum.autorespond')
                    ->with(['namalengkap' => $this->namalengkap]);
    }
}
