<?php

namespace App\Http\Resources\API\Errors;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollaborationErrorResource extends JsonResource
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
            'code' => 500,
            'message' => 'Error collaboration',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(500, 'Error collaboration');
    }
}
