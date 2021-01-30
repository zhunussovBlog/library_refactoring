<?php


namespace App\Models\Acquisition\Common;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait FetchQuery
{
    protected static function getFetchedQuery(Builder $query): array
    {
        return DB::select(DB::raw("select * from ({$query->toSql()}) FETCH NEXT 20 ROWS ONLY"), $query->getBindings());
    }
}
