<?php

namespace App\Http\Controllers\Api\Service;

use App\Common\Fields\Service\UserSearchFields;
use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Controller\Search;
use App\Common\Helpers\Query\QueryHelper;
use App\Common\Helpers\Search\FilterHelper;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\User\Employee;
use App\Models\User\Student;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function search(string $type, SearchRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page') ?? 10;

        $model = (match ($type) {
            'student' => Student::defaultQuery(),
            'employee' => Employee::defaultQuery(),
            default => throw new ReturnResponseException('Incorrect user type', 400),
        });

        $data = Search::search($request, QueryHelper::nestedQueryBuilder($model), new UserSearchFields());
        $forFilter = FilterHelper::forFilter($data, UserSearchFields::getFilterFields());

        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'filter' => $forFilter,
            'all' => $data->pluck('id')->toArray()
        ]);
    }
}
