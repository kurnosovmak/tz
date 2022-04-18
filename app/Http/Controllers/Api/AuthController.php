<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthController\LoginAuth;
use App\Http\Requests\AuthController\RegisterAuth;
use App\Http\Resources\TokenJson;
use App\Http\Resources\UserJson;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Login user.
     *
     * @param LoginAuth $request
     * @return JsonResponse
     */
    public function login(LoginAuth $request): JsonResponse
    {
        return (new TokenJson(null))->toResponse($request);
    }

    /**
     * Logout user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json(null, 205);
    }

    /**
     * Logout user.
     *
     * @param RegisterAuth $request
     * @return JsonResponse
     */
    public function register(RegisterAuth $request): JsonResponse
    {
        $user = User::register($request->email,$request->password);

        return (new UserJson($user))->toResponse($request);
    }
}
