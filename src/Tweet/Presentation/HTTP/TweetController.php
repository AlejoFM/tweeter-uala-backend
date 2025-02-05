<?php

declare(strict_types=1);

namespace App\Tweet\Presentation\HTTP;

use App\Http\Controllers\Controller;
use App\Tweet\Domain\Repositories\TweetRepositoryInterface;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function __construct(
        private TweetRepositoryInterface $tweetRepository
    ) {}

    public function store(Request $request): JsonResponse
    {
        $tweet = $this->tweetRepository->create(
            userId: $request->attributes->get('userId'),
            content: $request->input('content')
        );

        return response()->json(['data' => $tweet], 201);
    }

    public function show(int $id): JsonResponse
    {
        $tweet = $this->tweetRepository->findById($id);
        return response()->json(['data' => $tweet]);
    }

    public function timeline(Request $request): JsonResponse
    {
        $timeline = $this->tweetRepository->getTimelineByUserId(
            userId: $request->attributes->get('userId'),
            cursor: $request->input('cursor'),
            limit: $request->input('limit', 20)
        );

        return response()->json(['data' => $timeline]);
    }
} 