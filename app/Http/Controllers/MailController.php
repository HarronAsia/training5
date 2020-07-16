<?php

namespace App\Http\Controllers;

use App\Mail\Verification;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendverification($name, $email, $token)
    {
        $data = [
            'name' => $name,
            'token' =>$token
        ];

        Mail::to($email)->send(new Verification($data));
    }
}
