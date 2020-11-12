<?php

namespace App\Http\Resources\API\Errors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListDiscountCardErrorResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => 500,
            'message' => 'Error adding or removing (already added or deleted)',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(500, 'Error adding or removing');
    }
}
