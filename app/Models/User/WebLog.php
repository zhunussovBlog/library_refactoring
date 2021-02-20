<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebLog extends Model
{
    protected $table = 'web_log';
    protected $primaryKey = 'log_id';
    public $incrementing = false;

    protected $fillable = [
        'log_id', 'user_id', 'login_status', 'log_date', 'user_ip', 'device_info'
    ];

    public static function byWeek(): Builder
    {
        return self::whereByWeek(static::query()->select(
            DB::raw("trim(to_char(log_date, 'day')) as name"),
            DB::raw("count(*) as count")))
            ->groupBy(DB::raw("to_char(log_date, 'day')"));
    }

    public static function byMonths(): Builder
    {
        return static::query()->select(
            DB::raw("trim(to_char(log_date, 'month')) as name"),
            DB::raw("count(*) as count"))
            ->groupBy(DB::raw("to_char(log_date, 'month')"));
    }

    public static function whereByWeek(Builder $builder): Builder
    {
        return $builder->whereBetween('log_date',
            [DB::raw("to_date((next_day(sysdate, 'MON'))-7)"),
                DB::raw("to_date((next_day(sysdate, 'MON')-1))")]);
    }

    public static function whereByMonth(Builder $builder): Builder
    {
        return $builder->where(DB::raw("to_char(log_date, 'YYYY')"), DB::raw("to_char(sysdate, 'YYYY')"));
    }

    public static function total(): Builder
    {
        return static::query()->select(
            DB::raw("count(emp_id) as employees"), DB::raw("count(stud_id) as students")
        )->leftJoin('lib_user_cards', 'user_id', '=', 'user_cid');
    }

    public static function overall(): Builder
    {
        return static::query()->select(DB::raw("count(*) as count"));
    }
}
