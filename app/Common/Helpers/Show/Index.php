<?php


namespace App\Common\Helpers\Show;


use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Interfaces\Query\DefaultQueryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class Index
{
    public static function index(Request $request, DefaultQueryInterface $query): LengthAwarePaginator
    {
        $perPage = $request->get('per_page') ?? 10;
        $data = $query::defaultQuery()->get();

        return CustomPaginate::getPaginate($data, $request, $perPage);
    }
}
