@extends('layouts.master')

@section('title')
    {{ $book->title }}
@endsection

@push('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}
    <link href='/css/books/show.css' rel='stylesheet'>
@endpush

@section('content')
    <h1>{{ $book->title }}</h1>

    <p>
        @include('books._book')
    </p>
@endsection