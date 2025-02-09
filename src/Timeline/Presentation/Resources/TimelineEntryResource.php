<?php

declare(strict_types=1);

namespace src\Timeline\Presentation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TimelineEntryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => is_array($this->resource) ? $this->resource['id'] : $this->resource->id,
            'content' => is_array($this->resource) ? $this->resource['content'] : $this->resource->content,
            'user' => [
                'id' => is_array($this->resource) ? $this->resource['user_id'] : $this->resource->user_id,
                'username' => is_array($this->resource) ? $this->resource['username'] : $this->resource->username
            ],
            'created_at' => is_array($this->resource) ? $this->resource['created_at'] : $this->resource->created_at,
            'updated_at' => is_array($this->resource) ? $this->resource['updated_at'] : $this->resource->updated_at
        ];
    }
}