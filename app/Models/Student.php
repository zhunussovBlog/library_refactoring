<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'dbmaster.students';

    protected $primaryKey = 'stud_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'stud_id',
        'name',
        'surname',
        'class',
        'status',
        'passw',
        'web_lan',
        'last_psw_set_date',
        'emp_id',
        'type',
        'name_native',
        'surname_native',
        'old_sdu_id',
        'patronymic',
        'prog_code_reg',
        'prog_year_reg',
        'last_login_info',
        'attempt_count',
        'attempt_date',
        'edu_level',
        'entrance_year',
        'study_count'
    ];

    protected $hidden = [
        'passw',
        'web_lan',
        'last_psw_set_date',
        'emp_id',
        'type',
        'name_native',
        'surname_native',
        'old_sdu_id',
        'patronymic',
        'prog_code_reg',
        'prog_year_reg',
        'last_login_info',
        'attempt_count',
        'attempt_date',
        'entrance_year',
        'study_count'
    ];
}
