<?php
namespace App\Http\Controllers;

use App\Utilities\Practice;
use Illuminate\Http\Request;
use IanLChapman\PigLatinTranslator\Parser;
use App\Book;
use App\Author;

class PracticeController extends Controller
{
    public function practice23()
    {
        $books = Book::with('tags')->get();

        foreach ($books as $book) {
            dump($book->title.' is tagged with: ');
            foreach ($book->tags as $tag) {
                dump($tag->name.' ');
            }
        }
    }

    public function practice22()
    {
        $book = Book::where('title', '=', 'The Great Gatsby')->first();

        dump($book->title.' is tagged with: ');
        foreach ($book->tags as $tag) {
            dump($tag->name);
        }
    }

    public function practice21()
    {
        $books = Book::with('author')->get();

        foreach ($books as $book) {

# Get the author from this book using the "author" dynamic property
# "author" corresponds to the the relationship method defined in the Book model
        $author = $book->author;

# Output
        dump($book->title . ' was written by ' . $author->first_name . ' ' . $author->last_name);
    }
    }
    /**
     * One to Many Read Example
     */
    public function practice20()
    {
        # Get the first book as an example
        $book = Book::first();

# Get the author from this book using the "author" dynamic property
# "author" corresponds to the the relationship method defined in the Book model
        $author = $book->author;

# Output
        dump($book->title.' was written by '.$author->first_name.' '.$author->last_name);
        dump($book->toArray());
    }

    /**
     * One eto Many Create Example
     */
    public function practice19()
    {
        $author = Author::where('first_name', '=', 'J.K.')->first();

        $book = new Book;
        $book->title = "Fantastic Beasts and Where to Find Them";
        $book->published_year = 2017;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9781338132311_p0_v2_s192x300.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/fantastic-beasts-and-where-to-find-them-j-k-rowling/1004478855';
        $book->author()->associate($author); # <--- Associate the author with this book
        #This is the same:
        #$book->author_id = $author->id;
        $book->save();
        dump($book->toArray());
    }
    public function practice18() {
        $books = Book::orderBy('id', 'desc')->get();
        $book = $books->first();
        dump($books);
        dump($book);
    }
    public function practice17()
    {
        # Same as Practice 16 but using points to operator instead
        $books = Book::all();

        foreach ($books as $book) {
            dump($book->title);
        }
    }
    public function practice16()
    {
        # using array syntax
        $books = Book::all();

        # loop through the Collection and access just the data
        foreach ($books as $book) {
            dump($book['title']);
        }
    }
    public function practice15()
    {
        $books = Book::all();

        #This will output a JSON string
        echo $books;
    }
    public function practice14 (){
        # The following queries return a Book object
        $results = Book::find(1);

        $results = Book::orderBy('title')->first();
        dump($results);

        # Yields a collection of multiple books
        $results = Book::all();

        $results = Book::orderBy('title')->get();
        dump($results->first());

        # Should match 1 book; yields a Collection of 1 Book
        $results = Book::where('author', 'F. Scott Fitzgerald')->get();

        # Should match 0 books; yields an empty Collection
        $results = Book::where('author', 'Virginia Wolf')->get();

        # Even though we limit it to 1 book, we're using the `get` fetch method so we get a Collection (of 1 Book)
        $results = Book::limit(1)->get();
    }
    public function practice13()
    {
        $book = Book::where('title', 'LIKE', 'J.K.%')->delete();
    }

    public function practice12()
    {
        $book = new Book();
        # First get a book to update
        $books = $book->where('author', '=', 'J.K. Rowling')->update(['author' => 'JK Rowling']);;

        dump($books);
        Practice::resetDatabase();
    }

    public function practice11()
    {
        $book = Book::orderByDesc('published_year')->get();
        dump($book);
    }

    public function practice10()
    {
        $book = Book::orderBy('title', 'asc')->get();
        dump($book);
    }

    public function practice9()
    {
        $book = Book::where('published_year', '>', '1950')->get();
        dump($book);
    }

    public function practice8()
    {
        $book = Book::orderBy('id', 'desc')->take(2)->get();
        dump($book);

        #alternative solution
        #$books = Book::latest()->limit(2)->get();
    }

    public function practice7()
    {
        # First get a book to delete
        $book = Book::where('author', '=', 'J.K. Rowling')->first();

        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    public function practice6()
    {
        # First get a book to update
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }

    public function practice5()
    {
        $book = new Book();
        $books = $book->all();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice4()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump('Added: ' . $book->title);
    }

    /**
     * Demonstrating using an external package
     */
    public function practice3()
    {
        $translator = new Parser();
        $translation = $translator->translate('Hello World');
        dump($translation);
    }

    /*
     * Demonstrating getting values from configs
     */
    public function practice2()
    {
        dump(config('mail.supportEmail'));
    }

    /**
     * Demonstrating the first practice example
     */
    public function practice1()
    {
        dump('This is the first example.');
    }

    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];
        # If no specific practice is specified, show index of all available methods
        if (is_null($n)) {
            # Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }

            # Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        } # Otherwise, load the requested method
        else {
            $method = 'practice' . $n;

            # Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        }
    }
}