<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    /**
     * Social Network Login
     *
     * Returns a authentication token to allow the use of the api.
     *
     * `GET https://example.com/api/v1/{provider}`
     *
     * Parameter | Type    | Status      | Description
     * --------- | ------- | ----------- | -----------
     * provider | string | required | `facebook` or `google`
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Social Authentication Callback
     *
     * Part of above redirect method flow.
     *
     * @hideFromAPIDocumentation
     * @param $provider
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback($provider)
    {
        try{
            $socialUser = Socialite::driver($provider)->stateless()->user();
        }catch(ClientException $ce){
            return response()->json([
                'message' => 'Invalid authorization credentials'
            ], 422);
        }

        $user = $this->findOrCreateUser($socialUser);

        // Generate Token
        $token = JWTAuth::fromUser($user);

        // Get expiration time
        $objectToken = JWTAuth::setToken($token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

        return response()->json([
            "user" => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ], 201);
    }

    /**
     * Try find a user on DB from a given social user, if not found creates one with social flag on
     *
     * @param $socialUser
     * @return User
     */
    private function findOrCreateUser($socialUser)
    {
        if ($authUser = User::where('email', $socialUser->email)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'social' => 'yes'
        ]);
    }
}
