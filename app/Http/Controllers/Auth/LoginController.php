<?php

namespace App\Http\Controllers\Auth;

use App\Common\Helpers\Controller\AuthProcedure;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $server = [
            'REMOTE_ADDR' => $request->server('REMOTE_ADDR'),
            'HTTP_USER_AGENT' => $request->server('HTTP_USER_AGENT')
        ];

        $user = AuthProcedure::auth($validated, $server);

        Auth::login($user);

        session()->put('user', $user);

        $token = $user->createToken(config('auth.token'));

        $user = Auth::user();

        return response()->json(['res' => [
            'access_token' => $token->accessToken,
            'expires_in' => $token->token->expires_at->diffInSeconds(Carbon::now()),
            'user' => $user,
        ]]);
    }
}
