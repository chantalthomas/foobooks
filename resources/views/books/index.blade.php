@extends('layouts.master')

@section('title')
    All books
@endsection

@section('content')



    <h2>Recently Added Books</h2>
    @foreach($newBooks as $book)
        <p>{{ $book['title'] }}</p>
    @endforeach

    <h1>All books</h1>

    @foreach($books as $book)
        @include('books._book')
    @endforeach
@endsection