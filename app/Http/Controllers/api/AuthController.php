<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    use ApiResopnseTrait;

    public function login(LoginUserRequest $request)
    {

        $request->validated($request->all());
        if (!Auth::attempt($request->only('email','password')))
        {
            return $this->apiResponse(null,'invalid credentials',401);
        }
        $user = User::firstWhere('email',$request->email);
        $token = $user->createToken('API token for ' . $user->email)->plainTextToken;
        return $this->apiResponse([
            'token'=> $token
        ],
            'Authenticated',
            200);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API token for ' . $user->email)->plainTextToken;

        return $this->apiResponse([
            'token' => $token,
        ], 'User registered successfully', 201);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->apiResponse(null, 'Logged out successfully', 200);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $request->user()->currentAccessToken()->delete();
        $newToken = $user->createToken('API token for ' . $user->email)->plainTextToken;

        return $this->apiResponse([
            'token' => $newToken
        ], 'Token refreshed', 200);
    }

}

