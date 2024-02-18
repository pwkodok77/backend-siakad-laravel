<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!user) {
            throw ValidationException::withMessages([
                'email'=> ['email incorrect']
            ]);
        }

        if(!Hash::check($request, $password, $user->password)){
            throw ValidationException::whitMessages([
                'password' => ['password incorrect']
            ]);
        }
        // jika berhasil generet token
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(
            [
                'jwt-token' => $user,
                'user' => new UserResource($user),
            ]
        );

    }
    Public function logout(Request $request)
    {
        $request->user()-tokens()->delete();
        return response()->json([
            'message' => 'logout successfully'
        ]);
    }
}
