<?php

namespace App\Models\Media;

use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Disc extends Model implements DefaultQueryInterface
{
    public $incrementing = false;
    protected $table = 'lib_discs as d';
    protected $primaryKey = 'd.disc_id';
    protected $fillable = [
        'disc_id',
        'name',
        'isbn',
        'issn',
        'publisher_id',
        'pub_year',
        'pub_city',
        'old_id',
        'parallel_title',
        'pub_info',
        'issue_number',
        'issue_date',
        'language',
        'type'
    ];

    public static function defaultQuery(): Builder
    {
        return static::query()->select('d.disc_id as id', 'd.name as title',
            'd.pub_year as year', 'p.name as publisher', 'd.language as language',
            'mt.title_' . app()->getLocale() . ' as type', 'd.type as type_key', 'd.isbn', 'd.issn',
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name) as author
                            from lib_book_authors a where a.disc_id = d.disc_id group by a.disc_id)"),
            DB::raw("(case when (select r.disc_id from lib_reserve_list r
                            where d.disc_id = r.disc_id and r.status = 1) is not null
                            then (select 1 from dual) else (select 0 from dual) end) as status"),
            'd.callnumber as call_number',
            DB::raw("(select count(*) from lib_inventory i where i.disc_id = d.disc_id and i.status = 1) as availability"))
            ->leftJoin('lib_publishers as p', 'p.publisher_id', '=', 'd.publisher_id')
            ->leftJoin('lib_material_types as mt', 'd.type', '=', 'mt.key');
    }
}
