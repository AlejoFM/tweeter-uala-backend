<?php

declare(strict_types=1);

namespace src\Timeline\Presentation\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TimelineCollection extends ResourceCollection
{
    public $collects = TimelineEntryResource::class;

    public function __construct(
        private array $timeline,
        private string $type
    ) {
        parent::__construct($timeline['data']);
        $this->additional([
            'meta' => [
                'cursor' => $timeline['cursor'] ?? null,
                'has_more' => $timeline['has_more'] ?? false,
            ],
            'message' => $this->getMessage()
        ]);
    }

    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'cursor' => $this->additional['meta']['cursor'] ?? null,
                'has_more' => $this->additional['meta']['has_more'] ?? false
            ]
        ];
    }

    private function getMessage(): string
    {
        return match($this->type) {
            'for_you' => 'For You timeline retrieved successfully',
            'following' => 'Following timeline retrieved successfully',
            default => 'Timeline retrieved successfully',
        };
    }
} 