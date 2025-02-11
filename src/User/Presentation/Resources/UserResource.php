<?php

namespace src\User\Presentation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($user)
    {
        $user = $this->resource;
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];
    }


}