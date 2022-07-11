<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class MailController extends Controller
{
    public function sendMail() {
        foreach (['bubaololo@gmail.com', 'bulldog_grrr@mail.ru'] as $recipient) {
            Mail::to($recipient)->send(new TestMail);
        }
    }
}
