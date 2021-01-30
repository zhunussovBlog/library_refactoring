<?php

namespace App\Http\Controllers\Api\Acquisition\Publisher;

use App\Helpers\ControllerHelpers\SearchData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Publisher\SearchRequest;
use App\Models\Acquisition\Publisher\Publisher;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(SearchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        SearchData::checkPageSearch(Publisher::class, $request, Publisher::CACHED_ID_NAME);
        $data = Publisher::search($validated);

        return response()->json(SearchData::processSearch($request, $data, Publisher::LAST_QUERY_NAME, Publisher::CACHED_ID_NAME));
    }

    public function autocomplete(SearchRequest $request): JsonResponse
    {
        $data = Publisher::autocomplete($request->validated());
        return response()->json(['res' => $data]);
    }
}
