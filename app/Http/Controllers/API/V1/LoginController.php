<?php

namespace App\Http\Controllers\API\V1;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\User as UserResource;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $tokenResult = $request->user()->createToken('eClick Personal Access Client');

        return (new UserResource($request->user()))
            ->additional(['meta' => [
                'token_type' => 'Bearer',
                'access_token' => $tokenResult->accessToken,
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            ]]);
    }
}
