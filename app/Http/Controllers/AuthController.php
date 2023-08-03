<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            throw new UnauthorizedException("ایمیل یا کلمه عبور اشتباه است.");
        }

        $user = User::query()->where('email', $request->email)->firstOrFail();
        $user->token = $user->createToken('api');

        return $user;
    }

    public function register(RegisterRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->token = $user->createToken('api');

        return $user;
    }
}
