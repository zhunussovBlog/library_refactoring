<?php

namespace App\Http\Controllers\Auth;

use App\Common\Helpers\Controller\AuthProcedure;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
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

        $user = Auth::user();

        return response()->json(['res' => [
            'user' => $user,
        ]]);
    }
}
