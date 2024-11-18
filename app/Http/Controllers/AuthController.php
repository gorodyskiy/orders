<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 
     * 
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            event(new Registered($user));
            Auth::login($user);
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'User registered and logedin successfully.',
                'data' => [
                    'user' => $user->name,
                    'token' => $user->createToken($user->name)->plainTextToken,
                    'token_type' => 'Barear',
                ],
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }

    /**
     * 
     * 
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->safe()->toArray())) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'User login successfully.',
                'data' => [
                    'user' => $user->name,
                    'token' => $user->createToken($user->name)->plainTextToken,
                    'token_type' => 'Barear',
                ],
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
    }

    /**
     * 
     * 
     * @return JsonResponse
     */
     public function logout(): JsonResponse
     {
        if (Auth::user()->currentAccessToken()->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User logout successfully.',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => '',
        ], 500);
     }
}
