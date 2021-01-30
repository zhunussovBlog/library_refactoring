<?php


namespace App\Models\Acquisition\Interfaces;


use Illuminate\Database\Eloquent\Builder;

interface Search
{
    public static function search(array $validated): Builder;
}
