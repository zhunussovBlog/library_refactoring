<?php


namespace App\Models\Acquisition\Item;


use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

trait ItemAdditional
{
    public static function materialTypes(): Builder
    {
        return DB::table('lib_material_types')
            ->select('key as item_type_key', 'title_' . app()->getLocale() . ' as item_type');
    }

    public static function locations(): Builder
    {
        return DB::table('sigle_types')
            ->select('key as location_key', 'title_' . app()->getLocale() . ' as location');
    }

    public static function currencies(): Builder
    {
        return DB::table('lib_currencies')
            ->select('code as currency_code', 'currency', 'title_' . app()->getLocale() . ' as currency_title');
    }

    public static function users(): EBuilder
    {
        return static::query()->select('i.user_cid', DB::raw("(case when u.stud_id is not null
                                                        then (select t.name||' '||t.surname from dbmaster.students t where u.stud_id = t.stud_id)
                                                        when u.emp_id is not null
                                                        then (select e.name||' '||e.sname from dbmaster.employee e where e.emp_id = u.emp_id) end) as username"))
            ->leftJoin('lib_user_cards as u', 'i.user_cid', '=', 'u.user_cid')
            ->whereNotNull('i.user_cid')->distinct();
    }

    public static function createdData(): array
    {
        $data = [];
        $types = self::materialTypes()->get()->toArray();

        $data['types'] = $types;

        $locations = self::locations()->get()->toArray();

        $data['locations'] = $locations;

        $currencies = self::currencies()->get()->toArray();

        $data['currencies'] = $currencies;

        $users = self::users()->get()->toArray();

        $data['users'] = $users;

        return $data;
    }
}
