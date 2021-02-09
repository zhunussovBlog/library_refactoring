<?php

namespace App\Http\Controllers\Api\Report\InventoryBooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\InventoryBooks\ExportRequest;
use App\Models\Acquisition\Item\Item;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;

class PrintController extends Controller
{
    public function __invoke(ExportRequest $request): Response
    {
        $validated = $request->validated();

        $data = Item::inventoryBooks()->whereIn('bii.inventory_no', $validated['inventories'])->get();
        $count = $data->count();
        $cost = $data->sum('cost');

        return PDF::loadView('prints.inventories', ['items' => $data, 'count' => $count, 'cost' => $cost, 'locale' => $validated['locale'] ?? app()->getLocale()])
            ->save(public_path('prints') . '/inventory_books.pdf')->stream();
    }
}
