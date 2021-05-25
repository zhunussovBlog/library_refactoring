<?php

namespace App\Http\Controllers\Api\Cataloging;

use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Models\Media\GetModels;
use App\Common\Helpers\Query\QueryHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $query = mb_strtolower($request->get('query', ''));
        $perPage = $request->get('per_page', 10);

        if (empty($query)) {
            return response()->json([
                'res' => [],
                'all' => []
            ]);
        }

        $materials = QueryHelper::unionAll(...GetModels::getModels())
            ->where(DB::raw("lower(isbn)"), 'like', $query . '%')
            ->orWhere(DB::raw("lower(title)"), 'like', $query . '%')
            ->orWhere(DB::raw("lower(author)"), 'like', $query . '%')
            ->get();

        return response()->json([
            'res' => CustomPaginate::getPaginate($materials, $request, $perPage),
            'all' => $materials->pluck('id')->toArray()
        ]);
    }
}
