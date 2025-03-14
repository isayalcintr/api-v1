<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\BaseApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseApiController
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->tokens()->delete();
                $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;
                return $this->successResponse('Logined!', ['user' => $user, 'access_token' => $token], Response::HTTP_OK);
            }
            return $this->errorResponse("Invalid credentials!", [], Response::HTTP_UNAUTHORIZED);
        }
        catch (\Exception $e) {
            return $this->successResponse($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();
            return $this->successResponse('Logged out successfully!', [], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me()
    {
        try{
            $user = Auth::user();
            return $this->successResponse('User data!', ['user' => $user], Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $this->successResponse($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
