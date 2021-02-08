<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'res' => [
                'user' => Auth::user()
            ]
        ]);
    }
}
