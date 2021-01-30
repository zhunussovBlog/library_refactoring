<?php


namespace App\Models\Acquisition\Common;


use Illuminate\Database\Eloquent\Builder;

trait LastCreated
{
    public static function lastCreated(int $id): Builder
    {
        return static::defaultQuery()->where(static::keyName(), $id);
    }
}
