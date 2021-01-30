<?php

namespace App\Http\Requests\Acquisition\Batch;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'batch_id' => 'required|integer',
            'inv_date' => 'required|date',
            'items_no' => 'required|integer',
            'titles_no' => 'required|integer',
            'doc_no' => 'required|integer',
            'sup_type' => 'nullable|alpha',
            'sup_id' => 'nullable|integer',
            'contract_no' => 'nullable|string',
            'inv_details' => 'nullable|string',
            'cost' => 'required|integer',
        ];
    }
}
