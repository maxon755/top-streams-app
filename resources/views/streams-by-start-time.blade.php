@extends('layouts.app')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Started At</th>
            <th>Game</th>
            <th>Viewers</th>
            <th>Title</th>
            <th>Channel</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($streamsGroupedByStartTime as $startedAt => $streams)
            <tr>
                <td>{{$startedAt}}</td>
                <td></td>
            </tr>

            @foreach ($streams as $stream)
                <tr>
                    <td></td>
                    <td>{{$stream->game_name}}</td>
                    <td>{{$stream->viewers_count}}</td>
                    <td>{{$stream->title}}</td>
                    <td>{{$stream->channel_name}}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
@endsection
