<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:user',
            'name' => 'required|max:100',
            'password'  => 'required|min:3|confirmed',
            'state' => 'array|required',
            'state.list' => 'array|required',
            'state.list.lists' => 'array|required',
            'state.list.lists.*.external_id' => 'uuid|unique:list,external_id',
            'state.list.lists.*.title' => 'string|required|max:50',
            'state.product' => 'array|nullable',
            'state.product.products' => 'array|nullable',
            'state.product.products.*.external_id' => 'uuid|unique:product,external_id',
            'state.product.products.*.title' => 'string|required|max:50',
            'state.product.products.*.marked' => 'boolean|required',
            'state.product.products.*.unit' => 'nullable|string|max:10',
            'state.product.products.*.list_id' => 'uuid|required',
            'state.product.products.*.product_group_id' => 'nullable|uuid',
        ];
    }
}
