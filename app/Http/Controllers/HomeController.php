<?php

namespace App\Http\Controllers;

use App\Repositories\StreamRepository;
use App\Http\Requests\GetTopStreamsByViewersCountRequest;

class HomeController extends Controller
{
    public function __construct(private StreamRepository $streamRepository)
    {
    }

    public function index()
    {
        return view('home');
    }

    public function streamsByGame()
    {
        $streamsByGame = $this->streamRepository->getStreamCountGroupedByName();


        return view('streams-by-game', [
            'streamsByGame' => $streamsByGame
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

    public function getStreamsByStartTime()
    {
        $streamsGroupedByStartTime = $this->streamRepository->getStreamsGroupedByStartTime();

        return view('streams-by-start-time', [
            'streamsGroupedByStartTime' => $streamsGroupedByStartTime
        ]);
    }
}
