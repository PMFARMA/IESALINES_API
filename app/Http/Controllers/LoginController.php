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
    // public function login(Request $request)
    // {
        
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return auth()->user();
        // }

        // $password = $credentials['password'];
        // $user = User::where('email', $credentials['email'])->where('password', $password)->first();
        // if($user){
        //     Auth::login($user);
        //     return new UserResource(auth()->user());
        // }


        // return response()->json(["message" => "Las credenciales no coinciden con ningún usuario"], 422);
    // }


    public function logout(Request $request)
    {
    
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(["message" => "Sesión cerrada correctamente"], 201);
    }

    // function attemptLogin(Request $request)
    // {
    //     $password = $request->passwd;
    //     $user = User::where('email',$request->email)->where('passwd', $password)->first();

    //     if ($user) {
    //         $this->guard()->login($user, $request->has('remember'));
    //         return true;
    //     }

    //     return false;
    // }


    public function login($email){

    //     // $request['email'] = $email;
    //     // $request['password'] = '1';

    //     // $credentials = $request->validate([
    //     //             'email' => ['required', 'email'],
    //     //             'password' => ['required'],
    //     //         ]);
      
    //     // if (Auth::attempt(["email"=>$email,"password"=>''])) {
    //     //     $request->session()->regenerate();
    //     //     return auth()->user();
    //     // }

        $user = User::where('email',$email)->first();

        if($user){
            Auth::login($user);
            return auth()->user();
        }else{
            return response()->json(["message"=>"no hay usuario con este email"],404);
        }
    }

}
