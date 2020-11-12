<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'list_id' => 'required|uuid',
            'external_id' => 'uuid',
            'title' => 'string|required|max:100',
            'unit' => 'max:10',
            'marked' => 'boolean|required'
//            'marked' => 'boolean'
//            'product' => 'array|required',
//            'product.*.title' => 'string|required|max:100',
//            'product.*.unit' => 'string|max:10',
//            'product.*.marked' => 'boolean'
        ];
    }
}
