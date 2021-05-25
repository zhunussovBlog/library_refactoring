<?php


namespace App\Common\Helpers\Controller;


use App\Common\Helpers\Query\OracleProcedure;
use PDO;

class EditMaterialProcedure
{
    public static function edit(array $validated): array
    {
        $procedure = new OracleProcedure('pkg_cataloging', [
            'pCallNumber' => ['value' => $validated['call_number']],
            'pIsbn' => ['value' => $validated['isbn']],
            'pTitle' => ['value' => $validated['title']],
            'pMainAuthor' => ['value' => $validated['main_author']],
            'pOtherAuthors' => ['value' => $validated['other_author']],
            'pPublisher' => ['value' => $validated['publisher']],
            'pPub_year' => ['value' => $validated['year']],
            'pPub_city' => ['value' => $validated['city']],
            'pPageNumber' => ['value' => $validated['page_number']],
            'pParallel_title' => ['value' => $validated['parallel_title']],
            'pTitle_related_info' => ['value' => $validated['title_related_info']],
            'pLanguage' => ['value' => $validated['lang_key']],
            'pType' => ['value' => $validated['type_key']],
            'pMaterialID' => ['value' => $validated['id']],
            'pRes' => ['value' => 0, 'isOut' => true, 'type' => PDO::PARAM_INT],
        ]);
        $procedure->call();
        return $procedure->getOutputParams();
    }
}
