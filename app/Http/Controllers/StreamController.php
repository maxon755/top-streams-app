<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\StreamService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\StreamRepository;
use App\Http\Requests\GetTopStreamsByViewersCountRequest;

class StreamController extends Controller
{
    public function __construct(
        private StreamRepository $streamRepository,
        private StreamService $streamService
    )
    {
    }

    public function index()
    {
        return view('home');
    }

    public function streamsCountByGame()
    {
        $streamsByGame = $this->streamRepository->getStreamCountGroupedByName();

        return view('streams-count-by-game', [
            'streamsByGame' => $streamsByGame
        ]);
    }

    public function mostViewedStreamsByGame()
    {
        $mostViewedStreams = $this->streamRepository->getMostViewedStreamsByGame();

        return view('most-viewed-streams-by-game', [
            'streams' => $mostViewedStreams
        ]);
    }

    public function medianViewersCount()
    {
        $medianViewersCount = $this->streamRepository->getMedianViewersCount();

        return view('median-viewers', [
            'median' => $medianViewersCount,
        ]);
    }

    public function topStreamsByViewerCount(GetTopStreamsByViewersCountRequest $request)
    {
        $sort = $request->get('sort');

        $streams = $this->streamRepository->getTopStreamsByViewersCount($sort);

        return view('top-viewed-streams', [
            'streams' => $streams
        ]);
    }

    public function streamsByStartTime()
    {
        $streamCountByStartTime = $this->streamRepository->getStreamCountByStartTime();

        return view('streams-by-start-time', [
            'streamCountByStartTime' => $streamCountByStartTime
        ]);
    }

    public function followedStreamsFromTop()
    {
        /** @var User $user */
        $user = Auth::user();

        $followedStreams = $this->streamService->getUserFollowedStreamsFromTop($user);

        return view('followed-streams', [
            'streams' => $followedStreams
        ]);
    }

    public function viewersGap()
    {
        /** @var User $user */
        $user = Auth::user();

        $viewersGap = $this->streamService->getViewersGapBetweenLowestUserStreamAndLowestTopStream($user);

        return view('viewers-gap', [
            'viewersGap' => $viewersGap
        ]);
    }
}
