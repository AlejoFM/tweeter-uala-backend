<?php

namespace src\Tweet\Presentation\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Domain\ValueObjects\TweetContent;


class TweetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $tweet = $this->resource;

        return [
            'id' => $tweet->getId(),
            'content' => $tweet->getContent()->value(),
            'user' => [
                'user_id' => UserId::fromInt($tweet->getUserId()->value()),
                'username' => $tweet->getUser()->getUsername()
            ],
            'created_at' => $tweet->getCreatedAt(),
            'user_id' => $tweet->getUser()->getId()


        ];
    }
}

