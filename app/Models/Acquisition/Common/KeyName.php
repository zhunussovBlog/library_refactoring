<?php


namespace App\Models\Acquisition\Common;

trait KeyName
{
    public static function keyName(): string
    {
        return (new static)->getKeyName();
    }
}
