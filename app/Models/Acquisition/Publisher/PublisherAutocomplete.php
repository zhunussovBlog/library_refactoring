<?php


namespace App\Models\Acquisition\Publisher;


trait PublisherAutocomplete
{
    public static function autocomplete(array $validated): array
    {
        return static::getFetchedQuery(static::searchName(static::query()->select('p.publisher_id as id', 'p.name'), $validated['name']));
    }
}
