@extends('layouts.app')

@section('content')
    <h3> Order:
        <a href="{{route('top-viewed-streams', ['sort' => 'asc'])}}">Ascending</a>
        <a href="{{route('top-viewed-streams', ['sort' => 'desc'])}}">Descending</a>
    </h3>

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
