<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListDiscountCardRequest extends FormRequest
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
            'list_id' => 'required|exists:list,external_id',
            'discount_card_id' => 'required|exists:discount_card,id',
        ];
    }
}
