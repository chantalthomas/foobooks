@extends('layouts.master')

@section('title')
    Add a book
@endsection

@section('content')
    <h1>Add a book</h1>

    <form method='POST' action='/books'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}

        <label for='title'>* Title</label>
        <input type='text' name='title' id='title' value='{{ old('title', 'Green Eggs and Ham') }}'>
        @include('modules.field-error', ['field' => 'title'])

        <label for='author_id'>* Author</label>
        <select name='author_id'>
            <option value=''>Choose one...</option>
            @foreach($authors as $author)
                <option value='{{ $author->id }}' {{ (old('author_id') ==  $author->id) ? 'selected': ''  }}>{{ $author->first_name. ' ' .$author->last_name }}</option>
            @endforeach
        </select>
        @include('modules.field-error', ['field' => 'author_id'])

        <label for='published_year'>* Published Year (YYYY)</label>
        <input type='text' name='published_year' id='published_year' value='{{ old('published_year', '1960') }}'>
        @include('modules.field-error', ['field' => 'published_year'])

        <label for='cover_url'>* Cover URL</label>
        <input type='text' name='cover_url' id='cover_url' value='{{ old('cover_url', 'https://prodimage.images-bn.com/pimages/9780375973963_p0_v1_s550x406.jpg') }}'>
        @include('modules.field-error', ['field' => 'cover_url'])

        <label for='purchase_url'>* Purchase URL </label>
        <input type='text' name='purchase_url' id='purchase_url' value='{{ old('purchase_url', 'https://www.barnesandnoble.com/w/green-eggs-and-ham-dr-seuss/1100170349') }}'>
        @include('modules.field-error', ['field' => 'purchase_url'])

        <input type='submit' value='Add book'>
    </form>

    @if(count($errors) > 0)
        <ul class='alert'>
            Please correct the errors above.
        </ul>
    @endif
@endsection