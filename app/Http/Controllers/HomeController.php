<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $twitch = new \romanzipp\Twitch\Twitch();

        $result = $twitch->getStreams();

        dd($result);

        return 'zxc';
    }
}
