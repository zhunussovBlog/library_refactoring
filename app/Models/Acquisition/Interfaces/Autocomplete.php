<?php


namespace App\Models\Acquisition\Interfaces;


interface Autocomplete
{
    public static function autocomplete(array $validated): array;
}
