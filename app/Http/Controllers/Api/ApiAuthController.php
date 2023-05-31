<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        //validate dengan Auth::attempt
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        //token lama dihapus, token baru dicreate
        $user->tokens()->delete();
        $token = $user->createToken('token')->plainTextToken;
        return new LoginResource([
            'token' => $token,
            'user'=> $user
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('token')->plainTextToken;
        return new LoginResource([
            'token' => $token,
            'user'=> $user
        ]);
    }

    public function logout(Request $request)
    {
        //hapus token by token
        // $request->user()->currentAccessToken()->delete();
        //hapus token by user
        $request->user()->tokens()->delete();
        return response()->noContent();
    }
}
