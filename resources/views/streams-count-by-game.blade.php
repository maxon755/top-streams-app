@extends('layouts.app')

@section('content')
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Game</th>
            <th>Streams Number</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach ($streamsByGame as $row)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$row->game_name}}</td>
                <td>{{$row->streamsCount}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
@endsection
