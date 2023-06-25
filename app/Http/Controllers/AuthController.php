<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $tokenResult = explode('|',$tokenResult)[1];
            return response()->json([
                'message' => 'Вход выполнен',
                'access_token' => $tokenResult
            ]);
        }

        return response()->json([
            'message' => 'Неверный email или пароль'
        ], 401);
    }
}
