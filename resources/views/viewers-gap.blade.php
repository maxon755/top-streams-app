@extends('layouts.app')

@section('content')
    @if(is_null($viewersGap))
        You do not follow any streams not within TOP 1000
    @else
        The viewers gap between your lowest viewed stream and lowest from TOP 1000 is {{$viewersGap}}
    @endif

@endsection
