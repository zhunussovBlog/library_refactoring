<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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
}
