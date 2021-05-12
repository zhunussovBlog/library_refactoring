<?php

namespace App\Http\Controllers\Api\Service;

use App\Common\Fields\Service\UserSearchFields;
use App\Common\Helpers\Controller\CustomPaginate;
use App\Common\Helpers\Controller\Search;
use App\Common\Helpers\Query\QueryHelper;
use App\Common\Helpers\Search\FilterHelper;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Models\Acquisition\Item\Item;
use App\Models\Media\Book;
use App\Models\Media\Loan;
use App\Models\User\Employee;
use App\Models\User\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(string $type, SearchRequest $request): JsonResponse
    {
        $perPage = $request->get('per_page') ?? 10;

        $model = (match ($type) {
            'student' => Student::defaultQuery(),
            'employee' => Employee::defaultQuery(),
            default => throw new ReturnResponseException('Incorrect user type', 400),
        });

        $data = Search::search($request, QueryHelper::nestedQueryBuilder($model), new UserSearchFields());
        $forFilter = FilterHelper::forFilter($data, UserSearchFields::getFilterFields());

        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'filter' => $forFilter,
            'all' => $data->pluck('id')->toArray()
        ]);
    }

    public function searchMedia(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'value' => 'required'
        ], $request->all());
        $value = mb_strtolower($validated['value']);

        $perPage = $request->get('per_page') ?? 10;
        $data = Book::defaultQuery()->addSelect('i.barcode', 'i.inv_id')
            ->leftJoin('lib_inventory as i', 'b.book_id', '=', 'i.book_id')
            ->where(DB::raw("lower(i.barcode)"), 'like', $value . '%')->get();

        return response()->json([
            'res' => CustomPaginate::getPaginate($data, $request, $perPage),
            'all' => $data->pluck('id')->toArray()
        ]);
    }

    public function getMediaWithStatusesByInventory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'barcodes' => 'required|array',
            'barcodes.*' => 'integer'
        ], $request->all());

        $data = Item::query()->select(
            DB::raw("(case when l.delivery_date is not null and i.status = 1 then 'not borrowed'
                            when current_date <= due_date then 'borrowed'
                            when current_date > due_date then 'borrowed'
                            else 'not borrowed' end) as status"), 'i.barcode', 'i.inv_id',
            DB::raw("(select b.title from lib_books b where b.book_id = i.book_id) as title"),
            DB::raw("(select listagg(a.name||a.surname, ', ') within group(order by a.name)
                            from lib_book_authors a where a.book_id = i.book_id group by a.book_id) as author"))
            ->leftJoin('lib_loans as l', 'l.inv_id', '=', 'i.inv_id')
            ->whereIn('i.barcode', $validated['barcodes'])->get()->unique('inv_id')->toArray();

        return response()->json([
            'res' => $data,
        ]);
    }
}
