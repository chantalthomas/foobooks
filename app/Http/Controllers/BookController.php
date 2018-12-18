<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Tag;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('title')->get();

        #Approach 1 - query the database
        #$newBooks = Book::latest()->limit(3)->get();

        #Approach 2 - query the collection, optimal
        $newBooks =$books->sortByDesc('created_at')->take(3);

        return view('books.index')->with([
            'books' => $books,
            'newBooks' => $newBooks
        ]);
    }

    public function showBook(Request $request, $id)
    {
        $book = Book::find($id);
        return view('books.showBook')->with(['book' => $book
        ]);
    }

    /**
     * GET
     * /books/search
     * Show the form to search for a book
     */
    public function search(Request $request)
    {
        return view('books.search')->with([
            'searchTerm' => session('searchTerm', ''),
            'caseSensitive' => session('caseSensitive', false),
            'searchResults' => $request->session()->get('searchResults', []),
        ]);
    }

    /**
     * GET
     * /books/search-process
     * Process the form to search for a book
     */
    public function searchProcess(Request $request)
    {
        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $searchResults = [];

        # Store the searchTerm in a variable for easy access
        # The second parameter (null) is what the variable
        # will be set to *if* searchTerm is not in the request.
        $searchTerm = $request->input('searchTerm', null);

        # Only try and search *if* there's a searchTerm
        if ($searchTerm) {
            # Open the books.json data file
            # database_path() is a Laravel helper to get the path to the database folder
            # See https://laravel.com/docs/helpers for other path related helpers
            $booksRawData = file_get_contents(database_path('/books.json'));

            # Decode the book JSON data into an array
            # Nothing fancy here; just a built in PHP method
            $books = json_decode($booksRawData, true);

            # Loop through all the book data, looking for matches
            # This code was taken from v0 of foobooks we built earlier in the semester
            foreach ($books as $title => $book) {
                # Case sensitive boolean check for a match
                if ($request->has('caseSensitive')) {
                    $match = $title == $searchTerm;
                    # Case insensitive boolean check for a match
                } else {
                    $match = strtolower($title) == strtolower($searchTerm);
                }

                # If it was a match, add it to our results
                if ($match) {
                    $searchResults[$title] = $book;
                }
            }
        }

        # Redirect back to the search page w/ the searchTerm *and* searchResults (if any) stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/books/search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $request->has('caseSensitive'),
            'searchResults' => $searchResults
        ]);
    }

    /**
     * GET /books/create
     * Display the form to add a new book
     */
    public function create(Request $request)
    {
        $authors = Author::getForDropdown();
        dump($authors->toArray());

        return view('books.create')->with([
            'authors' => $authors
        ]);
    }


    /**
     * POST /books
     * Process the form for adding a new book
     */
    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'published_year' => 'required|digits:4',
            'cover_url' => 'required|url',
            'purchase_url' => 'required|url'
        ]);

        $book = new Book();
        $book->title = $request->input('title');
        //$book->author = $request->input('author');

        //Approach One
        //$author = Author::find($request->author_id);
        //$book->author()->associate($author);

        //Approach Two (Quicker)
        $book->author_id = $request->author_id;

        $book->published_year = $request->input('published_year');
        $book->cover_url = $request->input('cover_url');
        $book->purchase_url = $request->input('purchase_url');
        $book->save();

        return redirect('/books')->with([
            'alert' => 'Your book was added.'
        ]);
    }

    /*
    * GET /books/{id}/edit
    */
    public function edit($id)
    {
        $book = Book::find($id);

        $authors = Author::getForDropdown();

        $tags = Tag::getForCheckboxes();

        $tagsForThisBook = $book->tags()->pluck('tags.id')->toArray();
        dump($tagsForThisBook);

        if (!$book) {
            return redirect('/books')->with([
                'alert' => 'Book not found.'
            ]);
        }

        return view('books.edit')->with([
            'book' => $book,
            'authors' => $authors,
            'tags' => $tags,
            'tagsForThisBook' =>$tagsForThisBook
        ]);
    }

    /*
    * PUT /books/{id}
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'author_id' => 'required',
            'published_year' => 'required|digits:4|numeric',
            'cover_url' => 'required|url',
            'purchase_url' => 'required|url',
        ]);

        //dd($request->tags);

        $book = Book::find($id);
        $book->tags()->sync($request->tags);

        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->purchase_url = $request->purchase_url;
        $book->save();

        return redirect('/books/'.$id.'/edit')->with([
            'alert' => 'Your changes were saved.'
        ]);
    }

    /*
    * GET /books/{id}/edit
    */
    public function delete($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect('/books')->with([
                'alert' => 'Book not found.'
            ]);
        }
        else{
            return view('books.delete')->with([
                'book' => $book
            ]);
        }
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->tags()->detach();
        $book->delete();

        return redirect('/books')->with([
            'alert' => '"' . $book->totle . '" was removed.'
        ]);
    }
}
