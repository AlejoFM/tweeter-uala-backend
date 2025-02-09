<?php

namespace src\User\Presentation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'created_at' => $user->created_at,
        ];
    }


}