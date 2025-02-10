<?php

namespace src\Timeline\Presentation\HTTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use src\Timeline\Presentation\Resources\TimelineCollection;
use src\Timeline\Domain\Repositories\ForYouTimelineRepositoryInterface;

class TimelineForYouController extends Controller
{
    public function __construct(
        private ForYouTimelineRepositoryInterface $timelineRepository
    ) {}


    /**
     * @OA\Get(
     *     path="/api/timeline/for-you",
     *     summary="Get the timeline for the authenticated user",
     *     tags={"Timeline"},
     *     security={{"userIdHeader":{}}},
     *     @OA\Parameter(
     *         name="cursor",
     *         in="query",
     *         description="The cursor to paginate through the timeline",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of items to return per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=20)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The timeline for the authenticated user"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $timeline = $this->timelineRepository->getForYou(
            userId: intval($request->header('X-User-Id')),
            cursor: $request->get('cursor'),
            limit: intval($request->get('limit', default: 20))
        );

        return TimelineCollection::make($timeline, 'for-you');
    }
}

