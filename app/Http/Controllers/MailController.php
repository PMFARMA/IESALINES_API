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
            "emailtest" => 'required',
        ]);
        // $amsg = $request->validate([
        //     "asuntotest" => 'required',
        // ]);
        $amsg = $request->get("asuntotest");
        // $amsg ='Enhorabuena! Has sido seleccionado como Jurado de los Premios Aspid';

        Mail::to('lauracatalanruiz11@gmail.com')->send(new EmailsMailable($tmsg,$amsg));
        return 'Mensaje enviado'; 
    }
}
