<?php


namespace App\Models\Acquisition\Interfaces;


use Illuminate\Database\Eloquent\Builder;

interface LastCreated
{
    public static function lastCreated(int $id): Builder;
}
