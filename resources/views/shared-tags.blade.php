@extends('layouts.app')

@section('content')
    @if($tags->isEmpty())
        Your followed streams do not share any tags with streams of TOP 1000
    @else
        Shared tags:

        <list>
            @foreach($tags as $tag)
                <li>{{$tag->name}}</li>
            @endforeach
        </list>
    @endif

@endsection
