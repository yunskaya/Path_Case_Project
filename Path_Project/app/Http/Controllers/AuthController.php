<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //$email = $request->json()->email;
        
        $email = $request->email; 
        $password = $request->password;
        
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            
            $user = Auth::user();
            $success['token'] = $user->CreateToken("Login")->accessToken;
            
            return response()->json([
                'success' => $success
            ], 200);
        }
        else{
            return response()->json([
                'error' => 'Unauthorized'
            ],401);
        }

    }

    public function logout(Request $request)
    {
        if (Auth::check()) 
        {
            $user=Auth::user()->token();
            $user->revoke();
            
            return response()->json([
                'message' => 'success logout.'
            ], 200);
        }
        
    }
}
