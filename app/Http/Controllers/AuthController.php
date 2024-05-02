<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AturGrup;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(AuthRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('api_token')->plainTextToken;
            updateTokenUsed();
            $daftarAkses = $this->daftarAkses($user->id);
            $akses_grup = $daftarAkses[0]->grup_id;

            $respon_data = [
                'message' => 'Login successful',
                'data' => $user,
                'access_token' => $token,
                'akses_grup' => $akses_grup,
                'daftar_akses' => $this->daftarAkses($user->id),
                'token_type' => 'Bearer',
            ];
            return response()->json($respon_data, 200);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function daftarAkses($user_id)
    {
        $getAkses = AturGrup::with('grup')->where('user_id', $user_id)->get();
        if ($getAkses->isEmpty()) {
            return [];
        }
        return $getAkses;
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            if ($request->user()->tokens()->count() > 0) {
                $request->user()->tokens()->delete();
            }
        }
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
