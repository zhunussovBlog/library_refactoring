<?php

namespace App\Http\Controllers\Api\Cataloging;

use App\Common\Helpers\Controller\EditMaterialProcedure;
use App\Exceptions\ReturnResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cataloging\EditMaterialRequest;
use Illuminate\Http\JsonResponse;

class ActionsController extends Controller
{
    public function __invoke(EditMaterialRequest $request): JsonResponse
    {
        if ((int)EditMaterialProcedure::edit($request->validated())['pRes'] !== 1) {
            throw new ReturnResponseException('Process error', 100);
        }

        return response()->json([
            'res' => [
                'message' => 'success',
                'result' => true,
            ]
        ]);
    }
}
