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
        $textomsg = $request->validate([
            "textomsg" => 'required',
        ]);
        $asuntomsg = $request->validate([
            "asuntomsg" => 'required',
        ]);
        $asuntomsg = $asuntomsg["asuntomsg"];

        $emailtomsg = $request->validate([
            "emailtomsg" => 'required',
        ]);
        // return $emailtomsg;
        // $amsg = $request->get("asuntotest");
        // $amsg ='Enhorabuena! Has sido seleccionado como Jurado de los Premios Aspid';

        Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg));
        // Mail::to('lauracatalanruiz11@gmail.com')->send(new EmailsMailable($textomsg,$asuntomsg));
        return response()->json(['message'=>'Mensaje enviado'],201); 
    }
}
