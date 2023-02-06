<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailsMailable;
use Illuminate\Support\Facades\URL;
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
        $typemsg = $request->get('typemsg');
        switch ($typemsg) {
            case 'invitacion':
                // return'hola';
                // return $request->id;
                $url= URL::signedRoute('aceptacion', ['user'=>$request->id]);
                $separateUrl=explode('/',$url);
                $urlToFront=env('URL_FRONT_ACEPTACION').$separateUrl[count($separateUrl)-1]; 
                // $urlToFront='hola';
                Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,$urlToFront));
                return response()->json(['message'=>'Mensaje enviado'],201); 
                break;
            case 'iniciacion':
                Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,null));
                return response()->json(['message'=>'Mensaje enviado'],201); 
                break;
            case 'recordatiorio':
                Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,null));
                return response()->json(['message'=>'Mensaje enviado'],201); 
                break;
        }
        // return $emailtomsg;
        // $amsg = $request->get("asuntotest");
        // $amsg ='Enhorabuena! Has sido seleccionado como Jurado de los Premios Aspid';

        // Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg));
        // Mail::to('lauracatalanruiz11@gmail.com')->send(new EmailsMailable($textomsg,$asuntomsg));
        // return response()->json(['message'=>'Mensaje enviado'],201); 
    }
}
