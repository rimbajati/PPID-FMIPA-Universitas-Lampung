<?php

namespace App\Mail;

use App\Models\Pengajuan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->pengajuan->jenis_layanan === 'Keberatan'
            ? 'Pengajuan Keberatan Terkirim - ' . $this->pengajuan->no_tiket
            : 'Pengajuan Permohonan Informasi Terkirim - ' . $this->pengajuan->no_tiket;

        return $this->subject($subject)
                    ->view('email.pengajuan_dikirim');
    }
}
