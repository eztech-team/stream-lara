<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function userRegister($data) : string
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        
        return $this->createToken($user);
    }

    public function userLogin($data) : string
    {
        $user = Auth::attempt($data);

        if(!$user){
            return response(['message' => 'Unauthorized'], 401);
        }

        $user = request()->user();

        return $this->createToken($user);
    }

    protected function createToken($user) : string
    {
        $str = Str::random(12);
        return $user->createToken($str)->plainTextToken;
    }
}