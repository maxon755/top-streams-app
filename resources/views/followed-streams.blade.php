@extends('layouts.app')


@if (count($streams) === 0)
    @section('content')
        You don`t follow any stream from TOP 1000
    @endsection
@else
    @section('content')
        You follow next streams from TOP 1000:
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Channel</th>
                <th>Game</th>
                <th>Viewers</th>
                <th>Title</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1 ?>
            @foreach ($streams as $stream)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$stream->channel_name}}</td>
                    <td>{{$stream->game_name}}</td>
                    <td>{{$stream->viewers_count}}</td>
                    <td>{{$stream->title}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
    @endsection
@endif
