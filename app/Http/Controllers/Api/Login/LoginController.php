<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        $credentials = request()->only(['username', 'password']);
        if (!auth()->validate($credentials)) {
            abort(401);
        } else {
            $user = User::where('username', $credentials['username'])->first();
            $user->tokens()->delete();
            $token = $user->createToken('login');
            return response()->json(['token' => $token->plainTextToken]);
        }
    }
}
