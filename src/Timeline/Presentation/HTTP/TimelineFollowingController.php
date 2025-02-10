<?php

namespace src\Timeline\Presentation\HTTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use src\Timeline\Presentation\Resources\TimelineCollection;
use src\Timeline\Domain\Repositories\FollowingTimelineRepositoryInterface;

class TimelineFollowingController extends Controller

{
    public function __construct(
        private FollowingTimelineRepositoryInterface $timelineRepository
    ) {}


    /**
     * @OA\Get(
     *     path="/api/timeline/following/{userId}",
     *     summary="Get the timeline for a specific user",
     *     tags={"Timeline"},
     *     security={{"userIdHeader":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="The ID of the user to get the timeline for",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *         description="The timeline for the specified user"
     *     )    
     * )
     */
    public function index(Request $request, int $userId)
    {
        $timeline = $this->timelineRepository->getFollowing(
            userId: $userId,
            cursor: $request->get('cursor'),
            limit: intval($request->get('limit', 20))
        );

        return TimelineCollection::make($timeline, 'following');
    }
}

