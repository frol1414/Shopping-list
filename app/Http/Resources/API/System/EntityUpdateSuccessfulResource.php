<?php

namespace App\Http\Resources\API\System;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityUpdateSuccessfulResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code' => 200,
            'message' => 'Entity update successful',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200, 'Entity update successful');
    }
}
