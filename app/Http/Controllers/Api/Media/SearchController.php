<?php

namespace App\Http\Controllers\Api\Media;

use App\Common\Fields\Media\MediaFields;
use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Controller\Search;
use App\Common\Helpers\Models\Media\GetModels;
use App\Common\Helpers\Query\QueryHelper;
use App\Common\Helpers\Search\FilterHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(SearchRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page') ?? 10;
        $data = Search::search($request, QueryHelper::unionAll(...GetModels::getModels()), new MediaFields());
        $forFilter = FilterHelper::forFilter($data, MediaFields::getFilterFields());

        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'filter' => $forFilter,
            'all' => $data->pluck('id')->toArray()
        ]);
    }
}
