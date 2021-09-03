<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends APIController
{
    /**
     * Attempt login
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        if (!Auth::attempt($inputs)) {
            return $this->respondNotOk([
                'error' => 'Login failed.',
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('kiva');

        return $this->respondOk([
            'access_token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Attempt Logout
     *
     * @param LogoutRequest $request
     *
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return $this->respondOk([]);
    }
}
