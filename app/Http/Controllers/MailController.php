<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailsMailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

use App\Models\User;
use App\Models\Edicion;

class MailController extends Controller

{
    // public function storemail(Request $request){
  
        // $textomsg = $request->validate([
        //     "textomsg" => 'required',
        // ]);
        // $asuntomsg = $request->validate([
        //     "asuntomsg" => 'required',
        // ]);
        // $asuntomsg = $asuntomsg["asuntomsg"];

        // $emailtomsg = $request->validate([
        //     "emailtomsg" => 'required',
        // ]);
        // $typemsg = $request->get('typemsg');
        // switch ($typemsg) {
            
        //     case 'invitacion':

        //         $encrypted = Crypt::encryptString($request->id);

        //         $url= URL::temporarySignedRoute('aceptacion',now()->addDays(2),['user'=>$encrypted]);

        //         $separateUrl=explode('/',$url);
                
        //         $urlToFront=env('URL_FRONT_ACEPTACION').$separateUrl[count($separateUrl)-1]; 
            
        //         Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,$urlToFront));
        //         return response()->json(['message'=>'Mensaje enviado'],201); 
        //         break;

            // case 'iniciacion':
            //     Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,null));
            //     return response()->json(['message'=>'Mensaje enviado'],201); 
            //     break;
            // case 'recordatiorio':
            //     Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,null));
            //     return response()->json(['message'=>'Mensaje enviado'],201); 
            //     break;

            // case 'login':

                // $conditionEdicion = true;

                // $user = User::select('id','admin')->where('email',$emailtomsg)->get();
                
                // $id_edicion = Edicion::select('id')->where('estado', 0)->get();

                // if(count($user) != 0){

                //     if(!$user[0]->admin){

                //         if($user[0]->id_edicion != $id_edicion[0]->id){
                //             $conditionEdicion = false;
                //         }
                //     }

                //     if($conditionEdicion){
                //         $encrypted = Crypt::encryptString($user[0]->id);
                
                //         $url= URL::temporarySignedRoute('login', now()->addDays(30),['email'=>$emailtomsg]);

                //         $separateUrl=explode('/',$url);
                        
                //         $urlToFront=env('URL_FRONT_LOGIN').$separateUrl[count($separateUrl)-1]; 

                //         Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,$urlToFront));

                //         return response()->json(['message'=>'Mensaje enviado'],201); 
                        
                //     }else{
                //         return response()->json(['message'=>'Usuario no admin no está registrado en esta edición'],201); 
                //     }
    
                // }else{
                //     return response()->json(['message'=>'Usuario no existente'],201);
                // }
    
    //             break;
    //     }
    // }

    public function mailToinvitacion(Request $request){

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

        $encrypted = Crypt::encryptString($request->id);

        $url= URL::temporarySignedRoute('aceptacion',now()->addDays(2),['user'=>$encrypted]);

        $separateUrl=explode('/',$url);
                
        $urlToFront=env('URL_FRONT_ACEPTACION').$separateUrl[count($separateUrl)-1]; 
            
        Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,$urlToFront));

        return response()->json(['message'=>'Mensaje enviado'],201); 
    }

    public function mailToIniciacion(Request $request){

        $textomsg = $request->validate([
            "textomsg" => 'required',
        ]);
        $asuntomsg = $request->validate([
            "asuntomsg" => 'required',
        ]);
        $asuntomsg = $asuntomsg["asuntomsg"];


        $emails_jurado = User::select('email')->where('id_tipojurado',$request->id_tipojurado)->get();

        foreach($emails_jurado as $email){

            Mail::to($email->email)->send(new EmailsMailable($textomsg,$asuntomsg,null));

        }
        

        return response()->json(['message'=>'Mensaje enviado'],201); 
        
    }

    public function mailToRecordatorio(Request $request){

        $textomsg = $request->validate([
            "textomsg" => 'required',
        ]);
        $asuntomsg = $request->validate([
            "asuntomsg" => 'required',
        ]);
        $asuntomsg = $asuntomsg["asuntomsg"];

        $emails_jurado = User::select('email')->where('id_tipojurado',$request->id_tipojurado)->get();

        foreach($emails_jurado as $email){

            Mail::to($email->email)->send(new EmailsMailable($textomsg,$asuntomsg,null));

        }

        return response()->json(['message'=>'Mensaje enviado'],201); 
        
    }

    public function mailToLogin(Request $request){
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

        $conditionEdicion = true;

        $user = User::select('id','admin')->where('email',$emailtomsg)->get();
        
        $id_edicion = Edicion::select('id')->where('estado', 0)->get();

        if(count($user) != 0){

            if(!$user[0]->admin){

                if($user[0]->id_edicion != $id_edicion[0]->id){
                    $conditionEdicion = false;
                }
            }

            if($conditionEdicion){
                $encrypted = Crypt::encryptString($user[0]->id);
        
                $url= URL::temporarySignedRoute('login', now()->addDays(30),['email'=>$emailtomsg]);

                $separateUrl=explode('/',$url);
                
                $urlToFront=env('URL_FRONT_LOGIN').$separateUrl[count($separateUrl)-1]; 

                Mail::to($emailtomsg)->send(new EmailsMailable($textomsg,$asuntomsg,$urlToFront));

                return response()->json(['message'=>'Mensaje enviado'],201); 
                
            }else{
                return response()->json(['message'=>'Usuario no admin no está registrado en esta edición'],201); 
            }

        }else{
            return response()->json(['message'=>'Usuario no existente'],201);
        }

    }
   
}
