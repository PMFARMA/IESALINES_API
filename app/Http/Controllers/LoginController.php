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
    public function generatePass(){
        $hashed_random_password = Hash::make(Str::random(8));
        return $hashed_random_password;
    }


    public function login(Request $request,$id){

        $decrypt = Crypt::decryptString($id);
        
        $user = User::where('id',$decrypt)->first();

        if($user){

            if(!$user->admin){
        
                return response()->json(["rol"=>$user->admin]);
            
            }else{
               
                $password = $this->generatePass();
                $user->password = $password;
                $user->save();
                $this->sendEmailToAdmin($password,$user->email);
                return response()->json(["rol"=>$user->admin]);
            }

        }else{
            return response()->json(["message"=>"no hay usuario con este email"],404);
        }
    }


    private function sendEmailToAdmin($password,$email){

        $textomsg = ["textomsg"=>'tu email es: '.$email.'
        <br/> tu contraseña es: '.$password];
        $asuntomsg = 'usuario y contraseña';

        Mail::to($email)->send(new EmailsMailable($textomsg,$asuntomsg,null));

    }

    public function loginAdmin(Request $request){

        $user = User::where('email',$request->email);
        
        if($user){
            if($user->password == $request->password){
                
                $encrypted = Crypt::encryptString($user->id);
                return response()->json(["rol"=>$user->admin,"id"=>$encrypted]);
            }else{
                return response()->json(["message"=>"contraseña incorrecta"]);
            }
        }else{
            return response()->json(["message"=>"no se ha encontrado al usuario"],404);
        }
    }
}
