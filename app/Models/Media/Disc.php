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
            'd.pub_year as year', 'd.language as language', 'd.callnumber as call_number',
            DB::raw("(select lm.title_" . app()->getLocale() . " from lib_material_types lm where lm.key = d.type) as type"),
            'd.type as type_key', 'd.isbn', 'd.issn',
            DB::raw("(select lp.name from lib_publishers lp where lp.publisher_id = d.publisher_id) as publisher"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.disc_id = d.disc_id group by a.disc_id) as author"),
            DB::raw("(select r.status from lib_reserve_list r where d.disc_id = r.disc_id) as status"),
            DB::raw("(select count(i.inv_id) from lib_inventory i where i.disc_id = d.disc_id and i.status = 1) as availability"));
    }

    public static function withAdditionalAttributes(Builder $builder): Builder
    {
        return $builder->addSelect(
            DB::raw("null as title_related_info"),
            DB::raw("null as page_number"),
            'd.pub_city as city',
            'd.parallel_title',
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.disc_id = d.disc_id and a.is_main = 1 group by a.disc_id) as main_author"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.disc_id = d.disc_id and a.is_main = 0 group by a.disc_id) as other_author")
        );
    }
}
