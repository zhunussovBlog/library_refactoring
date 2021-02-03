<?php

namespace App\Http\Controllers\Api\Acquisition\Item;

use App\Http\Controllers\Controller;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;

class AdditionalController extends Controller
{
    public function createData(): JsonResponse
    {
        $data = Item::createdData();
        return response()->json(['res' => $data]);
    }
}
