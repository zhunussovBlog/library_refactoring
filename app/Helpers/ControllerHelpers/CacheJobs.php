<?php


namespace App\Helpers\ControllerHelpers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CacheJobs
{
    public static function cacheSearchQuery(Collection $data, string $nameCachedID): void
    {
        Session::forget($nameCachedID);
        Session::put($nameCachedID, $data->pluck('id')->toArray());
    }

    public static function cacheLastQuery($query, string $nameLastQuery): void
    {
        Session::forget($nameLastQuery);
        Session::put($nameLastQuery, ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
    }

    public static function cacheCreatedData($id, string $nameCreatedID): void
    {
        Session::forget($nameCreatedID);
        Session::put($nameCreatedID, $id);
    }
}
