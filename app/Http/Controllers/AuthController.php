<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(AuthRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('api_token')->plainTextToken;

            $respon_data = [
                'message' => 'Login successful',
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
            return response()->json($respon_data, 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        // if ($request->user()) {
        //     if ($request->user()->tokens()->count() > 0) {
        //         $request->user()->tokens()->delete();
        //     } else {
        //         return response()->json(['message' => 'User is already logged out'], 200);
        //     }
        // } else {
        //     return response()->json(['message' => 'User is not authenticated'], 401);
        // }
        // return response()->json(['message' => 'Logged out successfully'], 200);
        if ($request->user()) {
            if ($request->user()->tokens()->count() > 0) {
                $request->user()->tokens()->delete();
            }
        }
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
