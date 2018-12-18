<div class='book cf'>
    <img class='cover' src='{{ $book->cover_url }}' alt='Cover image for the book {{ $book->title }}'>
    <a href='/books/{{ $book->id }}'><h3>{{ $book->title }}</h3></a>
    <ul>
        <li>by {{  $book->author->getFullName() }}</li>
        <li>Added {{  $book->created_at->format('m/d/y g:ia')  }}</li>
        <a href='/books/{{  $book->id  }}'>Views</a>
        <a href='/books/{{  $book->id  }}/edit'>Edit</a>
        <a href='/books/{{  $book->id  }}/delete'>Delete</a>
    </ul>
</div>