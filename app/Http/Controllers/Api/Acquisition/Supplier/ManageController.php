<?php

namespace App\Http\Controllers\Api\Acquisition\Supplier;

use App\Helpers\ControllerHelpers\ManageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Supplier\CreateRequest;
use App\Http\Requests\Acquisition\Supplier\UpdateRequest;
use App\Models\Acquisition\Supplier\Supplier;
use Illuminate\Http\JsonResponse;

class ManageController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $response = ManageData::create(Supplier::class, self::createInputs($request->validated()));
        return response()->json($response, 201);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = ManageData::update(Supplier::class, $validated['sup_id'], self::updateInputs($validated));
        return response()->json($response);
    }

    public function delete(int $id): JsonResponse
    {
        $response = ManageData::delete(Supplier::class, $id);
        return response()->json($response);
    }

    static function createInputs(array $validated): array
    {
        return [
            'supplier_name' => $validated['sup_name'],
            'bin/inn' => $validated['bin'] ?? '',
            'commercial_name' => $validated['com_name'] ?? '',
            'address' => $validated['address'] ?? '',
            'email' => $validated['email'] ?? '',
            'fax' => $validated['fax'] ?? '',
            'phone' => $validated['phone'] ?? '',
        ];
    }

    static function updateInputs(array $validated): array
    {
        return self::createInputs($validated);
    }
}
