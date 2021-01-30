<?php


namespace App\Models\Acquisition\Interfaces;


use Illuminate\Database\Eloquent\Builder;

interface Query
{
    public static function defaultQuery(): Builder;
}
