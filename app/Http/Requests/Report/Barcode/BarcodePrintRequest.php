<?php

namespace App\Http\Requests\Report\Barcode;

use Illuminate\Foundation\Http\FormRequest;

class BarcodePrintRequest extends FormRequest
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
            'inventories' => 'required|array',
            'inventories.*' => 'required|integer',
        ];
    }
}
