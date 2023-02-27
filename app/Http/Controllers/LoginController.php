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
            if($user->id>=1000){
                $rol = 1000;
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json(["token"=>$token,"rol"=>$rol]);

            }else{
                $rol = 999;
                $password = $this->generatePass();
                $user->password = $password;
                $user->save();
                $this->sendEmailToAdmin($password,$rol);
                
            }

        }else{
            return response()->json(["message"=>"no hay usuario con este email"],404);
        }
    }


    private function sendEmailToAdmin($password,$rol){
        return response()->json(["rol"=>$rol]);
    }

    public function loginAdmin(Request $request){

        $user = User::where('email',$request->email)->where('id_edicion',28);
        
        if($user){
            if($user->password == $request->password){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json(["token"=>$token,"rol"=>$rol,"id"=>$decrypt]);
            }
        }else{
            return response()->json(["message"=>"no se ha encontrado al usuario"],404);
        }
    }
}
