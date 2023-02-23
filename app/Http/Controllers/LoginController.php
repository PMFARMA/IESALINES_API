<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
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
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     // if (Auth::attempt($credentials)) {
    //     //     $request->session()->regenerate();
    //     //     return auth()->user();
    //     // }

    //     $password = $credentials['password'];
    //     $user = User::where('email', $credentials['email'])->where('password', $password)->first();
    //     if($user){
    //         Auth::login($user);
    //         return new UserResource(auth()->user());
    //     }


    //     return response()->json(["message" => "Las credenciales no coinciden con ningún usuario"], 422);
    // }


    // public function logout(Request $request)
    // {
    //     Auth::logout();

    //     $request->session()->invalidate();

    //     $request->session()->regenerateToken();

    //     return response()->json(["message" => "Sesión cerrada correctamente"], 201);
    // }

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


    public function login(Request $request){

        $decrypt = Crypt::decryptString($request->email);
        $user = User::where('email',$decrypt)->first();

        if($user){
            if($user->id>1000){
                $rol = 1000;
            }else{
                $rol = 999;
            }
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json(["token"=>$token,"rol"=>$rol]);

        }else{
            return response()->json(["message"=>"no hay usuario con este email"],404);
        }
    }
}
