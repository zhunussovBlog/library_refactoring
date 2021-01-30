<?php

namespace App\Http\Controllers\Api\Acquisition\Supplier;

use App\Helpers\ControllerHelpers\SearchData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Supplier\SearchRequest;
use App\Models\Acquisition\Supplier\Supplier;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(SearchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        SearchData::checkPageSearch(Supplier::class, $request, Supplier::CACHED_ID_NAME);
        $data = Supplier::search($validated);

        return response()->json(SearchData::processSearch($request, $data, Supplier::LAST_QUERY_NAME, Supplier::CACHED_ID_NAME));
    }

    public function autocomplete(SearchRequest $request): JsonResponse
    {
        $data = Supplier::autocomplete($request->validated());
        return response()->json(['res' => $data]);
    }
}
