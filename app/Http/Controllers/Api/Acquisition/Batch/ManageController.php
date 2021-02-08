<?php

namespace App\Http\Controllers\Api\Acquisition\Batch;

use App\Common\Helpers\Manage\Create;
use App\Common\Helpers\Manage\Delete;
use App\Common\Helpers\Manage\Update;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Batch\CreateRequest;
use App\Http\Requests\Acquisition\Batch\UpdateRequest;
use App\Models\Acquisition\Batch\Batch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ManageController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $response = Create::create(new Batch(), self::createInputs($request->validated(), $request->user()));
        return response()->json([
            'res' => $response
        ], 201);
    }

    static function createInputs(array $validated, $user): array
    {
        return [
            'invoice_date' => $validated['inv_date'],
            'create_date' => Carbon::now(),
            'items_no' => $validated['items_no'],
            'titles_no' => $validated['titles_no'],
            'doc_no' => $validated['doc_no'],
            'supply_type' => $validated['sup_type'] ?? null,
            'supplier_id' => $validated['sup_id'] ?? null,
            'contract_no' => trim($validated['contract_no'] ?? ''),
            'invoice_details' => trim($validated['inv_details'] ?? ''),
            'cost' => $validated['cost'],
            'user_id' => $user->user_cid,
        ];
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = Update::update(new Batch(), $validated['batch_id'], self::updateInputs($validated, $request->user()));
        return response()->json([
            'res' => $response
        ]);
    }

    static function updateInputs(array $validated, $user): array
    {
        return [
            'invoice_date' => $validated['inv_date'],
            'items_no' => $validated['items_no'],
            'titles_no' => $validated['titles_no'],
            'doc_no' => $validated['doc_no'],
            'supply_type' => $validated['sup_type'],
            'supplier_id' => $validated['sup_id'],
            'contract_no' => trim($validated['contract_no']),
            'invoice_details' => trim($validated['inv_details']),
            'cost' => $validated['cost'],
            'edited_by' => $user->user_cid
        ];
    }

    public function delete(int $id): JsonResponse
    {
        $response = Delete::delete(new Batch(), $id);
        return response()->json([
            'res' => $response
        ]);
    }
}
