<?php

namespace App\Http\Controllers\Api\Acquisition\Item;

use App\Helpers\ControllerHelpers\SearchData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Item\SearchRequest;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(SearchRequest $request): JsonResponse
    {
        $validated = $request->validated();
        SearchData::checkPageSearch(Item::class, $request, Item::CACHED_ID_NAME);
        $data = Item::search($validated);

        return response()->json(SearchData::processSearch($request, $data, Item::LAST_QUERY_NAME, Item::CACHED_ID_NAME));
    }
}
