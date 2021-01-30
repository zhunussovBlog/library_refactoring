<?php

namespace App\Http\Controllers\Api\Acquisition\Publisher;

use App\Helpers\ControllerHelpers\ManageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Publisher\CreateRequest;
use App\Http\Requests\Acquisition\Publisher\UpdateRequest;
use App\Models\Acquisition\Publisher\Publisher;
use Illuminate\Http\JsonResponse;

class ManageController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $response = ManageData::create(Publisher::class, self::createInputs($request->validated()));
        return response()->json($response, 201);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = ManageData::update(Publisher::class, $validated['pub_id'], self::updateInputs($validated));
        return response()->json($response);
    }

    public function delete(int $id): JsonResponse
    {
        $response = ManageData::delete(Publisher::class, $id);
        return response()->json($response);
    }

    static function createInputs(array $validated): array
    {
        return [
            'name' => $validated['pub_name'],
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
