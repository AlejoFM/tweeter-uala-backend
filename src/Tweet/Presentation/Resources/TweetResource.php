<?php

namespace src\Tweet\Presentation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TweetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tweet = $this->resource;

        return [
            'id' => $tweet->getId(),
            'content' => $tweet->getContent()->value(),
            'user' => [
                'user_id' => $tweet->getUser()->getId(),
                'username' => $tweet->getUser()->getUsername()
            ],
            'created_at' => $tweet->getCreatedAt(),
        ];
    }
}

