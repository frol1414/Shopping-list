<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this);
        return [
            'external_id' => $this->external_id,
            'title' => $this->title,
            'list_id' => $this->lists->external_id,
            'user_id' => $this->user_id,
            'product_group' => $this->product_group,
            'product_group_id' => $this->product_group_id,
            /*[
                'external_id' => $this->product_group,
            ],*/
            'unit' => $this->unit,
            'marked' => $this->marked,
        ];
    }
}
