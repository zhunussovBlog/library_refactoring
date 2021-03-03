<?php

namespace App\Models\Media;

use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model implements DefaultQueryInterface
{
    public $incrementing = false;
    protected $table = 'lib_books as b';
    protected $primaryKey = 'b.book_id';
    protected $fillable = [
        'book_id',
        'isbn',
        'title',
        'publisher_id',
        'pub_year',
        'pub_city',
        'editor',
        'translator',
        'page_num',
        'seriya',
        'sureli',
        'note',
        'old_id',
        'parallel_title',
        'title_related_info',
        'pub_info',
        'issue_number',
        'issue_date',
        'language',
        'type'
    ];

    public static function defaultQuery(): Builder
    {
        return static::query()->select('b.book_id as id', 'b.title as title',
            'b.pub_year as year', 'p.name as publisher', 'b.language as language',
            'mt.title_' . app()->getLocale() . ' as type', 'b.type as type_key', 'b.isbn', DB::raw("null as issn"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name) as author
                            from lib_book_authors a where a.book_id = b.book_id group by a.book_id)"),
            DB::raw("(case when (select r.book_id from lib_reserve_list r
                            where b.book_id = r.book_id and r.status = 1) is not null
                            then (select 1 from dual) else (select 0 from dual) end) as status"),
            'b.callnumber as call_number',
            DB::raw("(select count(*) from lib_inventory i where i.book_id = b.book_id and i.status = 1) as availability"))
            ->leftJoin('lib_publishers as p', 'p.publisher_id', '=', 'b.publisher_id')
            ->leftJoin('lib_material_types as mt', 'b.type', '=', 'mt.key');
    }
}
