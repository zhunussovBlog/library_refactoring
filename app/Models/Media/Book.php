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
            'b.pub_year as year', 'b.language as language', 'b.callnumber as call_number',
            DB::raw("(select lm.title_" . app()->getLocale() . " from lib_material_types lm where lm.key = b.type) as type"),
            'b.type as type_key', 'b.isbn', DB::raw("null as issn"),
            DB::raw("(select lp.name from lib_publishers lp where lp.publisher_id = b.publisher_id) as publisher"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.book_id = b.book_id group by a.book_id) as author"),
            DB::raw("(select r.status from lib_reserve_list r where b.book_id = r.book_id) as status"),
            DB::raw("(select count(i.inv_id) from lib_inventory i where i.book_id = b.book_id and i.status = 1) as availability"));
    }
}
