<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    Public function login(Requset $request){
        $request->validate([
            'email' =>'required|string|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            throw ValidationExcaption::withMessages([
                'emial' => ['email incorrect']
            ]);
        }

        if(!Hash::check ($request->password, $user->password)){
            throw ValidationException::withMessages([
                'password' => ['password incorrect']
            ]);
        }
    $token = $user->creaToken('api-token')->plainTextoken;
    return response()->json(
        [
            'jwt-token'=> $token,
            'user' => new UserResource($user),
        ]
    );
    }
    Public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message'=> 'logout successfully',
        ]);
    }
}

