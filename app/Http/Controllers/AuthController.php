<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JWTAuth;
use Hash;
use Validator;

class AuthController extends Controller
{

    /**
     * Basic Login
     *
     * Returns a authentication token to allow the use of the api.
     *
     * `POST https://example.com/api/v1/auth/login`
     *
     * Parameter | Type    | Status
     * --------- | ------- | -----------
     * email | string | required
     * password | string | required
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate credentials
        $validator = Validator::make($credentials, [
            'password' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid credentials',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        // Get user by email
        $user = User::where('email', $credentials['email'])->first();

        // Validate User
        if (!$user) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 422);
        }

        // check if is social user
        if (!$user->password || $user->social == 'yes') {
            return response()->json([
                'error' => 'This is a social account, if you want to login with with password instead social network, register first'
            ], 422);
        }

        // Validate Password
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 422);
        }

        // Generate Token
        $token = JWTAuth::fromUser($user);

        // Get expiration time
        $objectToken = JWTAuth::setToken($token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }

}