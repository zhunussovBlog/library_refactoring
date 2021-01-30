<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'dbmaster.employee';

    protected $primaryKey = 'emp_id';
    public $incrementing = false;

    protected $fillable = [
        'emp_id',
        'name',
        'sname',
        'hname',
        'degree_id',
        'ip',
        'status',
        'passw',
        'passw2',
        'state',
        'web_lan',
        'pswchdate',
        'reg_date',
        'name_native',
        'surname_native',
        'patronymic',
        'old_emp_id',
        'wage_rate',
        'academic_rank',
        'last_login_info',
        'attempt_count',
        'attempt_date',
    ];

    protected $hidden = [
        'degree_id',
        'ip',
        'passw',
        'passw2',
        'state',
        'web_lan',
        'pswchdate',
        'reg_date',
        'name_native',
        'surname_native',
        'patronymic',
        'old_emp_id',
        'wage_rate',
        'academic_rank',
        'last_login_info',
        'attempt_count',
        'attempt_date',
    ];

    protected $appends = ['is_admin'];

    public function getIsAdminAttribute(): bool
    {
        $permission = static::query()->select(DB::raw("dbmaster.GetPermitByUser(emp_id, ai.acc_id) as user_permit"),
            DB::raw("dbmaster.getpermitByUserJob(emp_id, ai.acc_id) as position_permit"),
            'ai.acc_level')
            ->leftJoin('dbmaster.acc_info as ai', 'ai.acc_id', '=', 7)
            ->where('emp_id', '=', $this->emp_id)->first();
        if (!empty($permission)) {
            $permitted = $permission->acc_level == "2" || $permission->user_permit == "1"
                || $permission->position_permit == "1";
        }

        return $permitted ?? false;
    }
}
