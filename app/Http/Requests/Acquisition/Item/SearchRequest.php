<?php

namespace App\Http\Requests\Acquisition\Item;

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
            'search_options' => 'nullable|array|min:1',
            'search_options.*' => 'nullable|array',
            'search_options.*.key' => 'nullable|string',
            'search_options.*.value' => 'nullable',
            'search_options.*.operator' => 'nullable|in:and,or',

            // These fields goes in array (search_options)
            /*'inv_id' => 'nullable|integer',
            'title' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:30',
            'batch_id' => 'nullable|integer',
            'barcode' => 'nullable|integer',*/

            'publisher_id' => 'nullable|integer',
            'pub_year' => 'nullable|digits:4',
            'pub_city' => 'nullable|string|max:250',
            'supplier_id' => 'nullable|integer',
            'sup_type' => 'nullable|alpha',
            'from_cost' => 'nullable|integer',
            'until_cost' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'item_type' => 'nullable|string|max:2',
            'user_cid' => 'nullable|string|max:7',
            'location' => 'nullable|string|max:10'];
    }
}
