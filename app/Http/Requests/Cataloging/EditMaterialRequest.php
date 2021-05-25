<?php

namespace App\Http\Requests\Cataloging;

use Illuminate\Foundation\Http\FormRequest;

class EditMaterialRequest extends FormRequest
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
            'call_number' => 'required|string',
            'isbn' => 'required|string',
            'title' => 'required|string',
            'main_author' => 'required|string',
            'other_author' => 'required|string',
            'publisher' => 'required|string',
            'year' => 'required|integer',
            'city' => 'required|string',
            'page_number' => 'required|integer',
            'parallel_title' => 'required|string',
            'title_related_info' => 'required|string',
            'lang_key' => 'required|string',
            'type_key' => 'required|string',
            'id' => 'required|integer',
        ];
    }
}
