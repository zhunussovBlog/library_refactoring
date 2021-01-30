<?php

namespace App\Http\Controllers\Api\Acquisition\Supplier;

use App\Helpers\ControllerHelpers\GetData;
use App\Http\Controllers\Controller;
use App\Models\Acquisition\Supplier\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $response = GetData::index($request, Supplier::defaultQuery(), Supplier::LAST_QUERY_NAME, Supplier::SORT_FIELDS);

        return response()->json($response);
    }

    public function show(int $id): JsonResponse
    {
        $response = GetData::show(Supplier::defaultQuery(), $id);
        return response()->json($response);
    }

    public function last(Request $request): JsonResponse
    {
        $response = GetData::last($request, Supplier::LAST_QUERY_NAME, Supplier::SORT_FIELDS);
        return response()->json($response);
    }

    public function lastCreated(Request $request): JsonResponse
    {
        $response = GetData::created($request, Supplier::class,
            Supplier::CREATED_ID_NAME, Supplier::LAST_QUERY_NAME, Supplier::SORT_FIELDS);
        return response()->json($response);
    }

    public function sortByFields(): JsonResponse
    {
        return response()->json(GetData::sortFields(Supplier::SORT_FIELDS));
    }
}
