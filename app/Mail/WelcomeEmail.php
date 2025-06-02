<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $first_name;
    public $voucher_code;

    public function __construct($first_name, $voucher_code)
    {
        $this->first_name = $first_name;
        $this->voucher_code = $voucher_code;
    }

    public function build()
    {
        return $this->view('emails.welcome');
    }
}
