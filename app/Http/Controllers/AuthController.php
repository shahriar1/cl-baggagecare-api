<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->isAdmin()) {
                return Response::json(['message' => 'You are logged in as an admin.', 'status' => true], 200);
            }

            Auth::logout();
            return Response::json(['message' => 'Only admin users are allowed to log in.', 'status' => false], 403);
        }

        return Response::json(['message' => 'The provided credentials do not match our records.', 'status' => false], 401);
    }



    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
