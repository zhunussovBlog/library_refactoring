<?php

namespace App\Models\Acquisition\Item;

use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model implements DefaultQueryInterface
{
    use ItemManage;
    use ItemAdditional;
    use ItemReports;

    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'lib_inventory as i';
    protected $primaryKey = 'i.inv_id';
    protected $fillable = [
        'inv_id',
        'book_id',
        'j_issue_id',
        'disc_id',
        'receive_date',
        'oda_id',
        'status',
        'old_inv_id',
        'hesab_id',
        'emeliyyat_no',
        'price',
        'currency',
        'barcode',
        'sigle_type',
        'user_cid',
        'user_name',
        'edited_by'
    ];

    public static function defaultQuery(): Builder
    {
        return static::query()->select('i.barcode', 'i.inv_id as id',
            'i.hesab_id as batch_id',
            DB::raw("(case when i.book_id is not null
                                then (select b.title from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.title from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.name from lib_discs d where d.disc_id = i.disc_id) end) as title"),
            DB::raw("(case when i.book_id is not null
                                then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
                                        from lib_book_authors a where a.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
                                        from lib_book_authors a where a.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select listagg(a.name||a.surname, ', ') within group(order by a.name)
                                        from lib_book_authors a where a.disc_id = i.disc_id)
                                         end) as author"),
            DB::raw("(case when i.book_id is not null
                                then (select b.isbn from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.isbn from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.isbn from lib_discs d where d.disc_id = i.disc_id) end) as isbn"),
            DB::raw("(case when i.book_id is not null
                                then (select b.pub_year from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.pub_year from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.pub_year from lib_discs d where d.disc_id = i.disc_id) end) as pub_year"),
            DB::raw("(case when i.book_id is not null
                                then (select b.pub_city from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.pub_city from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.pub_city from lib_discs d where d.disc_id = i.disc_id) end) as pub_city"),
            DB::raw("(case when i.book_id is not null
                                then (select mt.key||' - '||mt.title_" . app()->getLocale() . " from lib_material_types mt
                                        left join lib_books b on mt.key = b.type where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select mt.key||' - '||mt.title_" . app()->getLocale() . " from lib_material_types mt
                                        left join lib_journals j on mt.key = j.type
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select mt.key||' - '||mt.title_" . app()->getLocale() . " from lib_material_types mt
                                        left join lib_discs d on mt.key = d.type where d.disc_id = i.disc_id)
                                end) as item_type"),
            DB::raw("(case when i.book_id is not null
                                then (select mt.key from lib_material_types mt
                                        left join lib_books b on mt.key = b.type where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select mt.key from lib_material_types mt
                                        left join lib_journals j on mt.key = j.type
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select mt.key from lib_material_types mt
                                        left join lib_discs d on mt.key = d.type where d.disc_id = i.disc_id)
                                end) as item_key"),
            DB::raw("(case when i.book_id is not null
                                then (select p.name from lib_publishers p
                                        left join lib_books b on p.publisher_id = b.publisher_id where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select p.name from lib_publishers p
                                        left join lib_journals j on p.publisher_id = j.publisher_id
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select p.name from lib_publishers p
                                        left join lib_discs d on p.publisher_id = d.publisher_id
                                        where d.disc_id = i.disc_id)
                                 end) as publisher"),
            DB::raw("(case when i.book_id is not null
                                then (select p.publisher_id from lib_publishers p
                                        left join lib_books b on p.publisher_id = b.publisher_id where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select p.publisher_id from lib_publishers p
                                        left join lib_journals j on p.publisher_id = j.publisher_id
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select p.publisher_id from lib_publishers p
                                        left join lib_discs d on p.publisher_id = d.publisher_id
                                        where d.disc_id = i.disc_id)
                                 end) as publisher_id"),
            DB::raw("(select s.supplier_name from lib_suppliers s
                            left join lib_hesablar h on s.supplier_id = h.supplier_id where h.hesab_id = i.hesab_id) as supplier"),
            DB::raw("(select h.supplier_id from lib_hesablar h where h.hesab_id = i.hesab_id) as supplier_id"),
            DB::raw("(select spt.title_" . app()->getLocale() . " from lib_supply_types spt
                            left join lib_hesablar h on spt.key = h.supply_type where h.hesab_id = i.hesab_id) as sup_type"),
            DB::raw("(select (case when u.emp_id is not null
                            then (select e.name||' '||e.sname from dbmaster.employee e where e.emp_id = u.emp_id) end)
                            from lib_user_cards u where u.user_cid = i.user_cid) as created_by"),
            DB::raw("(select (case when u.emp_id is not null
                            then (select e.name||' '||e.sname from dbmaster.employee e where e.emp_id = u.emp_id) end)
                            from lib_user_cards u where u.user_cid = i.edited_by) as edited_by"),
            'i.price as cost', 'i.currency', DB::raw("TO_CHAR(i.receive_date, 'YYYY-MM-DD') as create_date"),
            DB::raw("st.key||' - '||st.title_" . app()->getLocale() . " as location_title"),
            'st.key as location', 'i.user_cid',
            DB::raw("(case when i.tag_printed = 1 then 'printed'
                                       else 'not printed' end) as print_status"),
            DB::raw("(case when i.tag_initialized = 1 then 'initialized'
                                       else 'not initialized' end) as init_status"))
            ->leftJoin('sigle_types as st', 'st.key', '=', 'i.sigle_type');
    }
}
