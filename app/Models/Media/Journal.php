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
            'j.pub_year as year', 'p.name as publisher', 'j.language as language',
            'mt.title_' . app()->getLocale() . ' as type', 'j.type as type_key', 'j.isbn', DB::raw("null as issn"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.j_issue_id = ji.j_issue_id group by a.j_issue_id) as author"),
            DB::raw("(case when (select r.j_issue_id from lib_reserve_list r
                            where ji.j_issue_id = r.j_issue_id and r.status = 1) is not null
                            then (select 1 from dual) else (select 0 from dual) end) as status"),
            DB::raw("(select t.data from view_marc_fileds t where t.journal_id = j.journal_id and t.id = '010.a') as call_number"),
            DB::raw("(select count(*) from lib_inventory i where i.j_issue_id = ji.j_issue_id and i.status = 1) as availability"))
            ->leftJoin('lib_journal_issues as ji', 'j.journal_id', '=', 'ji.journal_id')
            ->leftJoin('lib_publishers as p', 'p.publisher_id', '=', 'j.publisher_id')
            ->leftJoin('lib_material_types as mt', 'j.type', '=', 'mt.key');
    }
}
