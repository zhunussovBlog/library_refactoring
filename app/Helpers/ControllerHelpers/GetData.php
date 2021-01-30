<?php


namespace App\Helpers\ControllerHelpers;


use App\Exceptions\ReturnResponseException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GetData
{
    public static function index(Request $request, $query, string $nameLastQuery, array $sortFields): array
    {
        $response = [];
        $perPage = $request->get('per_page') ?? 10;
        $page = $request->get('page');
        $orderBy = $request->get('order_by') ?? $sortFields[0]['key'];
        $orderMode = $request->get('order_mode') ?? 'desc';

        $query = $query->orderBy($orderBy, $orderMode);

        if (!isset($page) || empty($page)) {
            CacheJobs::cacheLastQuery($query, $nameLastQuery);
        }

        $data = CustomPaginate::getPaginate($query->get(), $request, $perPage);

        $response['res'] = $data;

        return $response;
    }

    public static function show(Builder $query, int $id): array
    {
        $response = [];

        $data = $query->find($id);

        if (empty($data)) {
            throw new ReturnResponseException(__('general.data_not_found'), 404);
        }

        $response['res'] = $data;
        return $response;
    }

    public static function last(Request $request, string $nameLastQuery, array $sortFields): array
    {
        $response = [];
        $lastQuery = Session::get($nameLastQuery);
        $perPage = $request->get('perPage') ?? 10;
        $orderBy = $request->get('order_by') ?? $sortFields[0]['key'];
        $orderMode = $request->get('order_mode') ?? 'desc';

        if (empty($lastQuery)) {
            throw new ReturnResponseException(__('general.no_cached_data'), 404);
        }

        $data = DB::table(DB::raw("({$lastQuery['sql']})"))
            ->setBindings($lastQuery['bindings'])
            ->select()->orderBy($orderBy, $orderMode)->get();

        $response['res'] = CustomPaginate::getPaginate($data, $request, $perPage);
        return $response;
    }

    public static function created(Request $request, $class, string $nameCreatedID, string $nameLastQuery, array $sortFields): array
    {
        $response = [];
        $id = Session::get($nameCreatedID);
        $orderBy = $request->get('order_by') ?? $sortFields[0]['key'];
        $orderMode = $request->get('order_mode') ?? 'desc';

        if (empty($id)) {
            throw new ReturnResponseException(__('general.no_cached_data'), 404);
        }

        $query = $class::lastCreated($id)->orderBy($orderBy, $orderMode);
        CacheJobs::cacheLastQuery($query, $nameLastQuery);

        $data = $query->first();

        $response['res'] = [$data];
        return $response;
    }

    public static function sortFields(array $sortFields): array
    {
        return ['res' => [
            // ... "sort by" fields of table
            'fields' => $sortFields,
            // ... mode of sorting -> ascending or descending
            'modes' => [
                ['key' => 'asc', 'title' => 'Ascending'],
                ['key' => 'desc', 'title' => 'Descending'],
            ],
        ]];
    }
}
