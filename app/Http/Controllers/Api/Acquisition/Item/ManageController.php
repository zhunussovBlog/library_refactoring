<?php

namespace App\Http\Controllers\Api\Acquisition\Item;

use App\Helpers\ControllerHelpers\ManageData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Item\CreateRequest;
use App\Http\Requests\Acquisition\Item\UpdateRequest;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;

class ManageController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $response = ManageData::create(Item::class, self::createInputs($request->validated(), $request->user()));
        return response()->json($response, 201);
    }

    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = ManageData::update(Item::class, $validated['inv_id'], self::updateInputs($validated, $request->user()));
        return response()->json($response);
    }

    public function delete(int $id): JsonResponse
    {
        $response = ManageData::delete(Item::class, $id);
        return response()->json($response);
    }

    static function createInputs(array $validated, $user): array
    {
        return [
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'item_type' => $validated['item_type'],
            'batch_id' => $validated['batch_id'],
            'publisher_id' => $validated['publisher_id'],
            'count' => $validated['count'],
            'cost' => $validated['cost'],
            'currency' => $validated['currency'],
            'location' => $validated['location'],
            'pub_year' => $validated['pub_year'],
            'pub_city' => $validated['pub_city'],
            'user_cid' => $user->user_cid
        ];
    }

    static function updateInputs(array $validated, $user): array
    {
        return [
            'cost' => $validated['cost'],
            'currency' => $validated['currency'],
            'location' => $validated['location'],
            'user_cid' => $user->user_cid
        ];
    }
}
