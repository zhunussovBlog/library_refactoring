<?php


namespace App\Models\Acquisition\Batch;


use Illuminate\Database\Eloquent\Builder;

trait BatchSearch
{
    public static function search(array $validated): Builder
    {
        $data = static::defaultQuery();

        if (!empty($validated['batch_id'])) {
            $data = $data->where('b.hesab_id', '=', $validated['batch_id']);
        }

        if (!empty($validated['sup_id'])) {
            $data = $data->where('b.supplier_id', '=', $validated['sup_id']);
        }

        if (!empty($validated['statuses'])) {
            $data = $data->whereIn('b.status', $validated['statuses']);
        }

        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
            $data = $data->whereBetween('b.create_date',
                [$validated['start_date'], $validated['end_date']]);
        } else if (!empty($validated['start_date'])) {
            $data = $data->whereRaw("b.create_date >= to_date(?, 'YYYY-MM-DD')",
                [$validated['start_date']]);
        } else if (!empty($validated['end_date'])) {
            $data = $data->whereRaw("b.create_date <= to_date(?, 'YYYY-MM-DD')",
                [$validated['end_date']]);
        }

        if (!empty($validated['from_cost']) && !empty($validated['until_cost'])) {
            $data = $data->whereBetween('b.cost',
                [$validated['from_cost'], $validated['until_cost']]);
        } else if (!empty($validated['from_cost'])) {
            $data = $data->whereRaw("b.cost >= ?",
                [$validated['from_cost']]);
        } else if (!empty($validated['until_cost'])) {
            $data = $data->whereRaw("b.cost <= ?",
                [$validated['until_cost']]);
        }

        return $data;
    }
}
