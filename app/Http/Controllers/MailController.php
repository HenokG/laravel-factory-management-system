<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public static function send($to_client)
    {
        Mail::to($to_client)->send(new OrderMail());

        return redirect()->back();
    }

}
