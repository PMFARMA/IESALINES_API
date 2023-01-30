<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    public function storemail(){
        $tmsg = $request->all();
        // return $tmsg;
        Mail::to('lauracatalanruiz11@gmail.com')->send(new EmailsMailable($tmsg));
        return 'Mensaje enviado'; 
    }
}
