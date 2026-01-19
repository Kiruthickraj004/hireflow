<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request){

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|max:255',
        'role' => 'required|in:candidate,employer'     
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json([
        'token' => $token,
        'user' => $user
    ],201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                "message" => "Invalid Credentials"
            ],401);
        }
        if($user->status !== 'active'){
            return response()->json([
                "message" => "account suspended"
            ],403);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            "token" => $token,
            "user" => $user 
        ]);
    }

    public function globals(Request $request){
        return $request->user();
    }
}
