<?php


namespace App\Models\Acquisition\Common;


trait ManageBuilder
{
    protected static function updateBuilder($class, string $keyName, int $id, array $attributes, array $fillable)
    {
        return $class::where($keyName, $id)->update(array_intersect_key($attributes, array_flip($fillable)));
    }

    protected static function deleteBuilder($class, string $keyName, int $id)
    {
        return $class::where($keyName, $id)->delete();
    }
}
