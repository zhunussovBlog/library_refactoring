<?php

namespace App\Http\Controllers\Api\Acquisition\Batch;

use App\Helpers\ControllerHelpers\SearchData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Batch\SearchRequest;
use App\Models\Acquisition\Batch\Batch;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(SearchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        SearchData::checkPageSearch(Batch::class, $request, Batch::CACHED_ID_NAME);
        $data = Batch::search($validated);

        return response()->json(SearchData::processSearch($request, $data, Batch::LAST_QUERY_NAME, Batch::CACHED_ID_NAME));
    }
}
