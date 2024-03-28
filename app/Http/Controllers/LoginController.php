<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            "username" => "required|string",
            "password" => "required|string"
        ]);

        $creds = $request->only("username", "password");

        $data = [];

        if (Auth::attempt($creds)) {
            $user = User::where("username", $request["username"])->first();
            $data = [
                "user" => new UserResource($data),
                "token" => $user->createToken("web")->plainTextToken
            ];
        }
        else{
            $data = [
                "error" => "Fout wachtwoord of gebruikersnaam"
            ];
        }

        return $data;
    }

    public function logout(){
        if(Auth::user()){
            Auth::logout();

            return response()->json("Logged out", 200);
        }
        else{
            return response()->json("No user logged in", 200);
        }
    }
}
