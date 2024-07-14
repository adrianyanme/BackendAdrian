<?php

namespace App\Mail\Persalinan;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Persalinan extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $namapemohon;
    public $noperkara;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$namapemohon,$noperkara)
    {
        $this->user = $user;
        $this->namapemohon = $namapemohon;
        $this->noperkara = $noperkara;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Permohonan Salinan Putusan ' . $this->user->username)
                    ->view('emails.persalinan.persalinan')
                    ->with(['namalengkap' => $this->namapemohon],['noperkara' => $this->noperkara]);
    }
}
