<?php

namespace App\Http\Resources\API\System;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessAddRemResource extends JsonResource
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
            'code' => 200,
            'message' => 'Successfully adding or removing',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(200, 'Successfully adding or removing');
    }
}
