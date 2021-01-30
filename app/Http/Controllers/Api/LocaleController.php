<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LocaleController extends Controller
{
    public function __invoke($locale): JsonResponse
    {
        if (!in_array($locale, config('locales'))) {
            throw new ReturnResponseException('There is no such locale language', 400);
        }

        session()->put('app_locale', $locale);

        return response()->json(['res' => [
            'message' => 'Locale initialized successfully',
        ]]);
    }
}
