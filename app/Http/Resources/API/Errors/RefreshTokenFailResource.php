<?php

namespace App\Http\Resources\API\Errors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefreshTokenFailResource extends JsonResource
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
            'code' => 401,
            'message' => 'Refresh token error',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(401, 'Refresh token error');
    }
}
