<?php


namespace App\Helpers\ControllerHelpers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;

class SearchData
{
    public static function processSearch(FormRequest $request, Builder $query, string $nameLastQuery, string $nameCachedID): array
    {
        CacheJobs::cacheLastQuery($query, $nameLastQuery);

        $data = $query->get();

        CacheJobs::cacheSearchQuery($data, $nameCachedID);

        $response['res'] = CustomPaginate::getPaginate($data, $request, $request->input('per_page') ?? 10);
        return $response;
    }

    public static function checkPageSearch($class, FormRequest $request, string $nameCachedID): array
    {
        $response = [];
        $perPage = $request->input('per_page') ?? 10;
        $page = $request->get('page');

        $cached = Session::get($nameCachedID);

        if (!empty($page) && $page > 0 && !empty($cached)) {
            $data = $class::defaultQuery()->whereIn($class::keyName(), $cached)->get();
            $data = CustomPaginate::getPaginate($data, $request, $perPage);

            $response['res'] = $data;
        }

        return $response;
    }
}
