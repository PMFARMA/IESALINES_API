<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailsMailable;

class LoginController extends Controller
{
    // /**
    //  * Handle an authentication attempt.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function login($email)
    // {
    //     $user = User::where('email', $email)->orderBy('id','desc')->first();

    //     if($user){
            
    //         Auth::login($user);
            
    //         $user = Auth::user();
    //     }


    //     return response()->json(["message" => "Las credenciales no coinciden con ningún usuario"], 422);
    // }


    public function logout(Request $request)
    {
    
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(["message" => "Sesión cerrada correctamente"], 201);
    }

    public function login(Request $request,$email)
    {
      

        $credentials["email"] = $email;
        $credentials["password"] = " ";

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return auth()->user();
        }

        $password = $credentials['password'];
        $user = User::where('email', $credentials['email'])->where('password', $password)->first();
        if($user){
            Auth::login($user);
            return new UserResource(auth()->user());
        }


        return response()->json(["message" => "Las credenciales no coinciden con ningún usuario"], 422);
    }

}
