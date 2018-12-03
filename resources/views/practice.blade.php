@extends('layouts.master')

@section('content')
    @foreach($methods as $method)
        <a href='{{ str_replace('practice', '/practice/', $method) }}'> {{ $method }}</a><br>
    @endforeach
    <br>
@endsection
