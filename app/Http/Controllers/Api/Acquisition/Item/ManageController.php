<?php

namespace App\Http\Controllers\Api\Acquisition\Item;

use App\Common\Helpers\Manage\Create;
use App\Common\Helpers\Manage\Delete;
use App\Common\Helpers\Manage\Update;
use App\Http\Controllers\Controller;
use App\Http\Requests\Acquisition\Item\CreateRequest;
use App\Http\Requests\Acquisition\Item\UpdateRequest;
use App\Models\Acquisition\Item\Item;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

class ManageController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        $response = Create::create(new Item(), self::createInputs($request->validated(), $request->user()));
        return response()->json([
            'res' => $response
        ]);
    }

    public static function createInputs(array $validated, $user): array
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

    public function update(UpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = Update::update(new Item(), $validated['inv_id'], self::updateInputs($validated, $request->user()));
        return response()->json([
            'res' => $response
        ]);
    }

    #[ArrayShape(['cost' => "mixed", 'currency' => "mixed", 'location' => "mixed", 'user_cid' => "mixed"])]
    public static function updateInputs(array $validated, $user): array
    {
        return [
            'cost' => $validated['cost'],
            'currency' => $validated['currency'],
            'location' => $validated['location'],
            'user_cid' => $user->user_cid
        ];
    }

    public function delete(int $id): JsonResponse
    {
        $response = Delete::delete(new Item(), $id);
        return response()->json([
            'res' => $response
        ]);
    }
}
