@extends('layouts.master')

@section('title')
    Edit {{ $book->title }}
@endsection

@section('content')
    <h1>Edit {{ $book->title }}</h1>

    <form method='POST' action='/books/{{ $book->id }}'>
        <div class='details'>* Required fields</div>

        {{ method_field('put') }}
        {{ csrf_field() }}

        <label for='title'>* Title</label>
        <input type='text' name='title' id='title' value='{{ old('title', $book->title) }}'>
        @include('modules.field-error', ['field' => 'title'])

        <label for='author_id'>* Author</label>
        <select name='author_id'>
            <option value=''>Choose one...</option>
            @foreach($authors as $author)
                <option value='{{ $author->id }}' {{ (old('author_id', $book->author->id) ==  $author->id) ? 'selected': ''  }}>{{ $author->first_name. ' ' .$author->last_name }}</option>
            @endforeach
        </select>
        @include('modules.field-error', ['field' => 'author'])

        <label for='published_year'>* Published Year (YYYY)</label>
        <input type='text'
               name='published_year'
               id='published_year'
               value='{{ old('published_year', $book->published_year) }}'>
        @include('modules.field-error', ['field' => 'published_year'])

        <label for='cover_url'>* Cover URL</label>
        <input type='text'
               name='cover_url'
               id='cover_url'
               value='{{ old('cover_url', 'https://prodimage.images-bn.com/pimages/9780375973963_p0_v1_s550x406.jpg') }}'>
        @include('modules.field-error', ['field' => $book->cover_url ])

        <label for='purchase_url'>* Purchase URL </label>
        <input type='text'
               name='purchase_url'
               id='purchase_url'
               value='{{ old('purchase_url', 'https://www.barnesandnoble.com/w/green-eggs-and-ham-dr-seuss/1100170349') }}'>
        @include('modules.field-error', ['field' => $book->purchase_url])

        <ul>
            @foreach($tags as $tagId => $tagName)
                <li><label><input {{ (in_array($tagId, $tagsForThisBook)) ? 'checked' : '' }} type='checkbox'
                                  name='tags[]'
                                  value='{{ $tagId }}'>{{ $tagName }}</label></li>
            @endforeach
        </ul>

        <input type='submit' value='Save Changes'>
    </form>

    @if(count($errors) > 0)
        <ul class='alert'>
            Please correct the errors above.
        </ul>
    @endif
@endsection