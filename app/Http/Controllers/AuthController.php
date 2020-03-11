<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /*
     * @param Request $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, AuthService $authService)
    {
        $userData = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $authService->register($userData['email'], $userData['password']);

        return response([
            'message' => "Registration is finished. Please check {$userData['email']} for activation instructions."
        ], 200);
    }

    /*
     * @param Request $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, AuthService $authService)
    {
        $loginData = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $token = $authService->login($loginData['email'], $loginData['password']);

        return response([
            'token' => $token
        ], 200);
    }

    /*
     * @param Request $request
     * @param AuthService $authService
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(Request $request, AuthService $authService)
    {
        $activationData = $this->validate($request, [
            'code' => 'required'
        ]);

        try {
            $authService->activate($activationData['code']);
        } catch (ValidationException $e) {
            return $this->buildFailedValidationResponse($request, $e->errors());
        }

        return response([
            'message' => 'User was successfully activated.'
        ], 200);
    }

    /*
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser(Request $request, AuthService $authService)
    {
        $tokenData = $this->validate($request, [
            'token' => 'required'
        ]);

        if ($user = $authService->authenticate($tokenData['token'])) {
            return response(new UserResource($user));
        } else {
            return response([ 'error' => 'Unauthorized'], 401);
        }
    }
}
