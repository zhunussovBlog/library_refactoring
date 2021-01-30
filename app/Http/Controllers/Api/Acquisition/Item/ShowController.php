<?php

namespace App\Http\Controllers\Api\Acquisition\Item;

use App\Helpers\ControllerHelpers\GetData;
use App\Http\Controllers\Controller;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $response = GetData::index($request, Item::defaultQuery(), Item::LAST_QUERY_NAME, Item::SORT_FIELDS);
        return response()->json($response);
    }

    public function show(int $id): JsonResponse
    {
        $response = GetData::show(Item::defaultQuery(), $id);
        return response()->json($response);
    }

    public function last(Request $request): JsonResponse
    {
        $response = GetData::last($request, Item::LAST_QUERY_NAME, Item::SORT_FIELDS);
        return response()->json($response);
    }

    public function lastCreated(Request $request): JsonResponse
    {
        $response = GetData::created($request, Item::class, Item::CREATED_ID_NAME,
            Item::LAST_QUERY_NAME, Item::SORT_FIELDS);
        return response()->json($response);
    }

    public function sortByFields(): JsonResponse
    {
        return response()->json(GetData::sortFields(Item::SORT_FIELDS));
    }
}
