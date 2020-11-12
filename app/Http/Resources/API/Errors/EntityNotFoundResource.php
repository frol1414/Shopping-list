<?php

namespace App\Http\Resources\API\Errors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityNotFoundResource extends JsonResource
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
            'code' => 404,
            'message' => 'Entity not found',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(404, 'Entity not found');
    }
}
