<?php

namespace App\Models\Media;

use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Journal extends Model implements DefaultQueryInterface
{
    public $incrementing = false;
    protected $table = 'lib_journals as j';
    protected $primaryKey = 'j.journal_id';
    protected $fillable = [
        'journal_id',
        'isbn',
        'title',
        'publisher_id',
        'publish_interval_id',
        'borc_verme',
        'diagonal',
        'pub_year',
        'pub_city',
        'editor',
        'page_num',
        'seriya',
        'old_id',
        'parallel_title',
        'title_related_info',
        'pub_info',
        'issue_number',
        'issue_date',
        'temp_publisher_title',
        'language',
        'type'
    ];

    public static function defaultQuery(): Builder
    {
        return static::query()->select('j.journal_id as id', 'j.title as title',
            'j.pub_year as year', 'j.language as language', 'j.callnumber as call_number',
            DB::raw("(select lm.title_en from lib_material_types lm where lm.key = j.type) as type"),
            'j.type as type_key', 'j.isbn', DB::raw("null as issn"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.j_issue_id = ji.j_issue_id group by a.j_issue_id) as author"),
            DB::raw("(select lp.name from lib_publishers lp where lp.publisher_id = j.publisher_id) as publisher"),
            DB::raw("(select decode(r.j_issue_id, null, 0, 1)
                          from lib_reserve_list r
                         where ji.j_issue_id= r.j_issue_id
                           and r.status = 1) as status"),
            DB::raw("(select count(i.inv_id)
                   from lib_inventory i
                  where i.j_issue_id = ji.j_issue_id
                    and i.status = 1) as availability"))
            ->leftJoin('lib_journal_issues as ji', 'j.journal_id', '=', 'ji.journal_id')
            ->leftJoin('lib_publishers as p', 'p.publisher_id', '=', 'j.publisher_id');
    }
}
