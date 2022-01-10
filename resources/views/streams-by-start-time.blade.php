@extends('layouts.app')

@section('content')
    <table>
        <thead>
        <tr>
            <th>Started At</th>
            <th>Stream Count</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($streamCountByStartTime as $startedAt => $streamCount)
            <tr>
                <td>{{$startedAt}}</td>
                <td style="text-align:center">{{$streamCount}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
