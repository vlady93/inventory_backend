<?php

namespace App\Services;

use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class EmailServices
{
    public function sendEmailWithCode($cuenta)
    {
        Mail::to('vlady3000hc@gmail.com')->send(new VerificationCodeMail($cuenta));
    }
}
