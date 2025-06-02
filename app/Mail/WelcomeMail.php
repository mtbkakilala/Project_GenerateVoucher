<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $voucherCode;

    public function __construct($first_name, $voucherCode)
    {
        $this->first_name = $first_name;
        $this->voucherCode = $voucherCode;
    }

    public function build()
    {
        return $this->subject('Welcome to Voucher App')
                    ->view('emails.welcome')
                    ->with([
                        'first_name' => $this->first_name,
                        'voucherCode' => $this->voucherCode,
                    ]);
    }
}
