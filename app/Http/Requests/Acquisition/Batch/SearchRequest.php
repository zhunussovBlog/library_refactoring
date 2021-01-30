<?php

namespace App\Http\Requests\Acquisition\Batch;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'batch_id' => 'nullable|integer',
            'sup_id' => 'nullable|integer',
            'statuses' => 'nullable|array',
            'statuses.*' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'from_cost' => 'nullable|integer',
            'until_cost' => 'nullable|integer',
        ];
    }
}
