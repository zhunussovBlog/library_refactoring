<?php

namespace App\Models\Media;

use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model implements DefaultQueryInterface
{
    protected $table = 'lib_loans as l';
    public $incrementing = false;
    protected $primaryKey = 'l.loan_id';
    protected $fillable = [
        'loan_id',
        'inv_id',
        'user_cid',
        'borrow_date',
        'due_date',
        'delivery_date',
        'locked',
        'old_id',
        'ceza',
        'ceza_odenib',
        'uzatma_sayi'
    ];

    public static function defaultQuery(): Builder
    {
        return static::query()->select(
            "l.loan_id as id", "l.borrow_date",
            DB::raw("(case when uc.emp_id is not null
                                  then e.hname
                                  when uc.stud_id is not null
                                  then s.stud_id end) as username"),
            DB::raw("(case when uc.emp_id is not null
                                  then e.name
                                  when uc.stud_id is not null
                                  then s.name end) as name"),
            DB::raw("(case when uc.emp_id is not null
                                  then e.sname
                                  when uc.stud_id is not null
                                  then s.surname end) as surname"),
            DB::raw("(case when uc.emp_id is not null
                                  then 'employee'
                                  when uc.stud_id is not null
                                  then 'student' end) as user_type"),
            DB::raw("(case when uc.emp_id is not null
                                then (select d.title_en from dbmaster.departments d
                                        where d.dep_code = dg.dep_code and d.son = 1)
                                when uc.stud_id is not null
                                then (select d.title_en from dbmaster.departments d
                                        where d.dep_code = dp.dep_code_f and d.son = 1) end) as department"),
            DB::raw("(case when uc.emp_id is not null
                                then (select d.dep_id from dbmaster.departments d
                                        where d.dep_code = dg.dep_code and d.son = 1)
                                when uc.stud_id is not null
                                then (select d.dep_id from dbmaster.departments d
                                        where d.dep_code = dp.dep_code_f and d.son = 1) end) as dep_id")
        )->leftJoin('lib_user_cards as uc', 'l.user_cid', '=', 'uc.user_cid')
            ->leftJoin('dbmaster.employee as e', 'uc.emp_id', '=', 'e.emp_id')
            ->leftJoin('dbmaster.students as s', 'uc.stud_id', '=', 's.stud_id')
            ->leftJoin('dbmaster.emp_gorev as eg', function ($join) {
                $join->on('eg.emp_id', '=', 'e.emp_id');
                $join->on('eg.esas_gorev', '=', 1);
                $join->on('eg.status', '=', 1);
            })->leftJoin('dbmaster.dep_gorev as dg', 'dg.dep_gorev_id', '=', 'eg.dep_gorev_id')
            ->leftJoin('dbmaster.stud_prog as sp', static function ($join) {
                $join->on('sp.stud_id', '=', 's.stud_id');
                $join->on('sp.prog_type', '=', DB::raw("'M'"));
            })->leftJoin('dbmaster.dep_programs as dp', static function ($join) {
                $join->on('dp.prog_code', '=', 'sp.prog_code');
                $join->on('dp.son', '=', 1);
            });
    }

    public static function mostReadBooks(): Builder
    {
        return static::query()
            ->select(DB::raw("(case when i.book_id is not null then i.book_id
                                    when i.disc_id is not null then i.disc_id
                                    when i.j_issue_id is not null then i.j_issue_id end) as id"),
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
                                then (select b.title from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.title from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.name from lib_discs d where d.disc_id = i.disc_id) end) as title"),
                DB::raw("(case when i.book_id is not null
                                then (select b.language from lib_books b where b.book_id = i.book_id)
                                when i.disc_id is not null
                                then (select d.language from lib_discs d where d.disc_id = i.disc_id)
                                when i.j_issue_id is not null
                                then (select j.language from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id) end) as language"),
                DB::raw("(case when i.book_id is not null
                                then (select b.isbn from lib_books b where b.book_id = i.book_id)
                                when i.j_issue_id is not null
                                then (select j.isbn from lib_journals j
                                        left join lib_journal_issues ji on j.journal_id = ji.journal_id
                                        where ji.j_issue_id = i.j_issue_id)
                                when i.disc_id is not null
                                then (select d.isbn from lib_discs d where d.disc_id = i.disc_id) end) as isbn"),
                DB::raw("count(l.loan_id) as count_issue"))
            ->leftJoin('lib_inventory as i', 'l.inv_id', '=', 'i.inv_id')
            ->groupBy('i.book_id', 'i.disc_id', 'i.j_issue_id')
            ->orderBy('count_issue', 'desc');
    }

    public static function byWeek(): Builder
    {
        return self::whereByWeek(static::query()->select(
            DB::raw("trim(to_char(l.borrow_date, 'day')) as name"),
            DB::raw("count(*) as count")))
            ->groupBy(DB::raw("to_char(l.borrow_date, 'day')"));
    }

    public static function byMonths(): Builder
    {
        return static::query()->select(
            DB::raw("trim(to_char(l.borrow_date, 'month')) as name"),
            DB::raw("count(*) as count"))
            ->groupBy(DB::raw("to_char(l.borrow_date, 'month')"));
    }

    public static function whereByWeek(Builder $builder): Builder
    {
        return $builder->whereBetween('l.borrow_date',
            [DB::raw("to_date((next_day(sysdate, 'MON'))-7)"),
                DB::raw("to_date((next_day(sysdate, 'MON')-1))")]);
    }

    public static function whereByMonth(Builder $builder): Builder
    {
        return $builder->where(DB::raw("to_char(l.borrow_date, 'YYYY')"), DB::raw("to_char(sysdate, 'YYYY')"));
    }

    public static function total(): Builder
    {
        return static::query()->select(
            DB::raw("count(uc.emp_id) as employees"), DB::raw("count(uc.stud_id) as students")
        )->leftJoin('lib_user_cards as uc', 'l.user_cid', '=', 'uc.user_cid');
    }

    public static function departments(): \Illuminate\Database\Query\Builder
    {
        return DB::table("dbmaster.departments")->select('dep_id as id', 'title_' . app()->getLocale() . ' as title')->orderBy('dep_id');
    }

    public static function overall(): Builder
    {
        return static::query()->select(DB::raw("count(*) as count"));
    }
}
