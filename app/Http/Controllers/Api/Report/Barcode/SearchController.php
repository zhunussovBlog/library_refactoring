<?php

namespace App\Http\Controllers\Api\Report\Barcode;

use App\Common\Fields\Report\BarcodeFields;
use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Controller\Search;
use App\Common\Helpers\Query\QueryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page') ?? 10;
        $data = Search::search($request, QueryHelper::nestedQueryBuilder(Item::barcodeQuery()), new BarcodeFields());
        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'all' => $data->pluck('id')->toArray()
        ]);
    }
}
