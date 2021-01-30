<?php


namespace App\Models\Acquisition\Publisher;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait PublisherSearch
{
    protected static function searchName(Builder $query, string $value): Builder
    {
        return $query->where(DB::raw("lower(p.name)"), 'like', '%' . mb_strtolower($value) . '%');
    }

    public static function search(array $validated): Builder
    {
        return static::searchName(static::defaultQuery(), $validated['name'] ?? '');
    }
}
