<?php


namespace App\Models\Acquisition\Supplier;


trait SupplierAutocomplete
{
    public static function autocomplete(array $validated): array
    {
        return static::getFetchedQuery(static::searchName(static::query()->select('s.supplier_id as id', 's.supplier_name as name'), $validated['name']));
    }
}
