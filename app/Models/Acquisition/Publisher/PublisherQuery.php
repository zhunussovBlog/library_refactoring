<?php


namespace App\Models\Acquisition\Publisher;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait PublisherQuery
{
    public static function defaultQuery(): Builder
    {
        return static::query()->select('p.publisher_id as id', 'p.name', 'p.commercial_name as com_name', 'p.address',
            DB::raw("(select listagg(c.contact, ', ') from lib_contacts c where c.publisher = p.publisher_id and c.type_id = 4) as email"),
            DB::raw("(select listagg(c.contact, ', ') from lib_contacts c where c.publisher = p.publisher_id and c.type_id = 1) as phone"),
            DB::raw("(select listagg(c.contact, ', ') from lib_contacts c where c.publisher = p.publisher_id and c.type_id = 5) as fax"));
    }

}
