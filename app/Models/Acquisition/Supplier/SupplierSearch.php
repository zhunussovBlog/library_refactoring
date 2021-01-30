<?php


namespace App\Models\Acquisition\Supplier;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait SupplierSearch
{
    public static function searchName(Builder $query, string $value): Builder
    {
        return $query->where(DB::raw("lower(s.supplier_name)"), 'like', '%' . mb_strtolower($value) . '%');
    }

    public static function search(array $validated): Builder
    {
        return static::searchName(static::defaultQuery(), $validated['name'] ?? '');
    }
}
