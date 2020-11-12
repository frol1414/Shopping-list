<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'external_id' => $this->product->external_id,
            'title' => $this->product->title,
            'list_id' => $this->title,
            'user_id' => $this->product->user_id,
            'product_group' => $this->product->product_group,
            'product_group_id' => $this->product->product_group_id,
            /*[
                'external_id' => $this->product_group,
        ],*/
            'unit' => $this->product->unit,
            'marked' => $this->product->marked,
        ];
    }
}
