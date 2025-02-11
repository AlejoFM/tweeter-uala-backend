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
            userId: intval($request->header('X-User-Id')),
            cursor: $request->get('cursor'),
            limit: intval($request->get('limit', 20))
        );

        return response()->json(['data' => $timeline]);
    }

    public function following(Request $request, int $userId): JsonResponse
    {
        $timeline = $this->timelineRepository->getFollowing(
            userId: $userId,
            cursor: $request->get('cursor'),
            limit: intval($request->get('limit', 20))
        );

        return response()->json(['data' => $timeline]);
    }
}