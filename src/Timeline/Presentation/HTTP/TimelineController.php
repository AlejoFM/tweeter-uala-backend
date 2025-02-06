<?php 
declare(strict_types=1);

namespace src\Timeline\Presentation\HTTP;

use App\Http\Controllers\Controller;
use src\Timeline\Domain\Repositories\TimelineRepositoryInterface;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function __construct(
        private TimelineRepositoryInterface $timelineRepository
    ) {}

    public function forYou(Request $request): JsonResponse
    {
        $timeline = $this->timelineRepository->getForYou(
            userId: $request->attributes->get('userId'),
            cursor: $request->input('cursor'),
            limit: $request->input('limit', 20)
        );

        return response()->json(['data' => $timeline]);
    }

    public function following(Request $request): JsonResponse
    {
        $timeline = $this->timelineRepository->getFollowing(
            userId: $request->attributes->get('userId'),
            cursor: $request->input('cursor'),
            limit: $request->input('limit', 20)
        );

        return response()->json(['data' => $timeline]);
    }
}