<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nama,$untuk)
    {
        $this->nama = $nama;
        $this->untuk = $untuk;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('verifikasiappku@gmail.com')
            ->markdown('emails.index')
            ->with([
                'nama' => $this->nama,
                'untuk' => $this->untuk
            ]);
    }
}
