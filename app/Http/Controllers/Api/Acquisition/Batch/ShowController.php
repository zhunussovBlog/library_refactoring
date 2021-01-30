<?php

namespace App\Http\Controllers\Api\Acquisition\Batch;

use App\Helpers\ControllerHelpers\GetData;
use App\Http\Controllers\Controller;
use App\Models\Acquisition\Batch\Batch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $response = GetData::index($request, Batch::defaultQuery(), Batch::LAST_QUERY_NAME, Batch::SORT_FIELDS);

        return response()->json($response);
    }

    public function show(int $id): JsonResponse
    {
        $response = GetData::show(Batch::defaultQuery(), $id);
        return response()->json($response);
    }

    public function last(Request $request): JsonResponse
    {
        $response = GetData::last($request, Batch::LAST_QUERY_NAME, Batch::SORT_FIELDS);
        return response()->json($response);
    }

    public function lastCreated(Request $request): JsonResponse
    {
        $response = GetData::created($request, Batch::class,
            Batch::CREATED_ID_NAME, Batch::LAST_QUERY_NAME, Batch::SORT_FIELDS);
        return response()->json($response);
    }

    public function sortByFields(): JsonResponse
    {
        return response()->json(GetData::sortFields(Batch::SORT_FIELDS));
    }
}
