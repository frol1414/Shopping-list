<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'barcode' => $this->barcode,
            'user_id' => $this->user_id,
            'color' => $this->color,
            'brand' => new DiscountCardBrandResource($this->ref_brand),
        ];
    }
}
