<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailsMailable;

class MailController extends Controller
{
    public function storemail(Request $request){
        // $tmsg = $request->all();
        // return $tmsg;
        $tmsg = $request->validate([
            "asuntotest" => 'required',
            "emailtest" => 'required',
        ]);
        Mail::to('lauracatalanruiz11@gmail.com')->send(new EmailsMailable($tmsg));
        return 'Mensaje enviado'; 
    }
}
