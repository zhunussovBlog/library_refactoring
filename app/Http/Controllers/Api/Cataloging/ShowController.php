<?php

namespace App\Http\Controllers\Api\Cataloging;

use App\Common\Fields\Cataloging\MediaFields;
use App\Common\Helpers\Show\SearchFields;
use App\Http\Controllers\Api\Cataloging\Handler\MarcFieldsHandler;
use App\Http\Controllers\Controller;
use App\Models\Media\MaterialTypeFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{
    public function getMaterialById(string $type, int $materialId): JsonResponse
    {
        $keyName = explode('.', MaterialTypeFactory::getMaterialClass($type)->getKeyName());

        $marcData = DB::table('view_marc_data')->select()->where($keyName[1] ?? $keyName[0], $materialId)->orderBy('id')->get()->toArray();
        $result = MarcFieldsHandler::generateArray($marcData);

        return response()->json([
            'res' => $result
        ]);
    }

    public function getTypes(): JsonResponse
    {
        return response()->json([
            'res' => DB::table('lib_material_types')
                ->select('key as type', 'title_' . app()->getLocale() . ' as type_title')
                ->get()->toArray(),
        ]);
    }

    public function searchFields(): JsonResponse
    {
        return response()->json([
            'res' => SearchFields::searchFields(new MediaFields())
        ]);
    }
}
