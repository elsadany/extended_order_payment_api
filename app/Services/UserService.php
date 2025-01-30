<?php 
 namespace App\Services;

use App\DTOs\LoginRequestDTO;
use App\DTOs\RegisterRequestDTO;
use App\Http\Resources\UserResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

 class UserService {

    function register(RegisterRequestDTO $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            
        ]);
        return [
            'token'    => JWTAuth::fromUser($user)
        ];
    }

    function login(LoginRequestDTO $request){
       

        if (!$token = JWTAuth::attempt($request->all())) {
            return null;
        }

        return [
            'token' => $token,
            'user' => JWTAuth::fromUser(auth()->user())
        ];
    }
 }