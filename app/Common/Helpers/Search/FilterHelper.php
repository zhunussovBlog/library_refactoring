<?php


namespace App\Common\Helpers\Search;


use App\Common\Helpers\Query\QuerySearchBuilder;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection;

class FilterHelper
{
    public static function filter(ECollection|Collection $data, array $fields, array $option)
    {
        $methodName = SearchHelper::getMethodName($option['key'], $fields);
        return QuerySearchBuilder::$methodName($data, $option['key'], $option['value']);
    }

    public static function forFilter(ECollection|Collection $data, array $fields): array
    {
        return $data->map(function ($item) use ($fields) {
            $res = [];

            foreach ($fields as $field) {
                $res[$field['key']][] = [
                    'value' => $item->$field['key'],
                    'title' => $item->$field['title_key']
                ];
            }

            return $res;
        })->toArray();
    }
}
