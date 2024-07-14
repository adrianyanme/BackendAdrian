<?php

namespace App\Mail\GugatanSederhana;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GugatanSederhana extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $nama_pengugat;
    public $nama_tergugat;
    public $tuntutan_pengugat;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$nama_pengugat,$nama_tergugat,$tuntutan_pengugat)
    {
        $this->user = $user;
        $this->nama_pengugat = $nama_pengugat;
        $this->nama_tergugat = $nama_tergugat;
        $this->tuntutan_pengugat = $tuntutan_pengugat;
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Permintaan Gugatan Sederhana Langusng ' . $this->user->username)
                    ->view('emails.gugatansederhana.gugatansederhana')
                    ->with(['nama_pengugat' => $this->nama_pengugat],['nama_tergugat' => $this->nama_tergugat],['tuntutan_pengugat' => $this->tuntutan_pengugat]);
    }
}
