<?php

namespace App\Http\Controllers\Api\Cataloging;

use App\Http\Controllers\Controller;
use App\Models\Media\Book;
use App\Models\Media\Disc;
use App\Models\Media\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function getMaterialById(int $materialId): JsonResponse
    {
        $material = Book::withAdditionalAttributes(Book::defaultQuery())->where('b.book_id', $materialId)->first();

        if (empty($material)) {
            $material = Disc::withAdditionalAttributes(Disc::defaultQuery())->where('d.disc_id', $materialId)->first();
        }

        if (empty($material)) {
            $material = Journal::withAdditionalAttributes(Journal::defaultQuery())->where('j.journal_id', $materialId)->first();
        }

        return response()->json([
            'res' => $material
        ]);
    }

    public function getEditData(): JsonResponse
    {
        $types = DB::table('lib_material_types')
            ->select('key as type_key', 'title_' . app()->getLocale() . ' as type')->get()->toArray();

        $languages = DB::table('language')
            ->select('lang_code as lang_key', 'lang_full_name as name', 'lang_name_' . app()->getLocale() . ' as language')->get()->toArray();

        return response()->json([
            'res' => [
                'types' => $types,
                'languages' => $languages
            ],
        ]);
    }
}
