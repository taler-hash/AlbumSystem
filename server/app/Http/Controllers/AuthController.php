<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {
        $user = User::where('username', $request->username)->first();
        
        if(!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => 'These credentials do not match our records.',
            ]);
        }

        return response()->json(['token' => $this->issueToken($user), 'user' => $user->load('roles')], 200);
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        return response()->json(['token' => $this->issueToken($user), 'user' => $user], 200);
    }

    public function logout() {
        Auth::guard('sanctum')->user()->currentAccessToken()->delete();
    }

    public function getUserDetails() {
        return response()->json(Auth::guard('sanctum')->user()->load('roles'), 200);
    }

    private function issueToken(User $user) {
        $token = $user->createToken('api');

        return $token;
    }
}
