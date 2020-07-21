<?php

namespace App\Http\Controllers;

use App\User;
use Cookie;
use DB;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        // Check if a user with the specified email exists
        $user = User::whereEmail(request('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status'  => 422,
            ], 422);
        }

        // If a user with the email was found - check if the specified password
        // belongs to this user
        if (!Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status'  => 422,
            ], 422);
        }
        return response()->json([
            'token'  => $token = $user->createToken('Personal Access Token')->accessToken,
            'user'   => $user,
            'status' => 200,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $cookie = Cookie::forget('_token');
        return response()->json([
            'message' => 'successful-logout',
        ])->withCookie($cookie);
    }

    public function register(Request $request)
    {
        $user           = new User;
        $user->email    = $request->email;
        $user->name     = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        $token  = $user->createToken('Personal Access Token')->accessToken;
        $cookie = $this->getCookieDetails($token);
        return response()
            ->json([
                'data'  => $user,
                'token' => $token,
            ], 200)
            ->cookie($cookie['name'], $cookie['value'], $cookie['minutes'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly'], $cookie['samesite']);
    }
}
