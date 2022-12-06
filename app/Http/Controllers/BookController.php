<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['ind ex', 'show']);
        $this->middleware('is_admin')->except('index', 'show');
    }

    public function index()
    {
        $query = request()->get('query');
        if ($query) {
            $books = Book::join('book_genre', 'book_genre.book_id', '=', 'books.id')
                ->join('genres', 'genres.id', '=', 'book_genre.genre_id')
                ->where('books.title', 'LIKE', '%' . $query . '%')
                ->orWhere('books.author', 'LIKE', '%' . $query . '%')
                ->orWhere('books.isbn', 'LIKE', '%' . $query . '%')
                ->orWhere('genres.name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->get(['books.*']);

            return view('books.index', ['books' => $books]);
        }

        $books = Book::all();
        return view('books.index', ['books' => $books]);
    }

    public function show($id)
    {
        $book = Book::with('genres')->find($id);

        if (!$book) {
            throw new NotFoundHttpException;
        }

        return view('books.show', ['book' => $book]);
    }

    public function create()
    {
        $genres = Genre::where('deleted', 0)->get();
        return view('books.create', ['genres' => $genres]);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'isbn' => ['required', 'max:255'],
            'price' => ['required', 'regex:((^(\d+)(\.?)(\d+)$)|^(\d)$)'],
            'pages' => ['required'],
            'cover_image' => ['nullable', 'max:1024'],
            'description' => ['nullable'],
            'released_at' => ['required', 'date'],
            'in_stock' => ['nullable']
        ]);

        $fields['in_stock'] = $request->has('in_stock');

        if ($request->hasFile('cover_image')) {
            $fields['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book = Book::create($fields);

        if ($request->genres) {
            foreach ($request->genres as $genreId) {
                try {
                    BookGenre::create([
                        'book_id' => $book->id,
                        'genre_id' => $genreId
                    ]);
                } catch (\Throwable $th) {
                    return redirect('/')->with('message', 'Book Created With Genres Errors!');
                }
            }
        }

        return redirect('/')->with('message', 'Book Created Successfully!');
    }

    public function edit($id)
    {
        $book = Book::find($id);

        if (!$book) {
            throw new NotFoundHttpException();
        }

        $genres = Genre::where('deleted', 0)->get();

        return view('books.edit', ['book' => $book, 'genres' => $genres]);
    }

    public function update(Request $request, $id)
    {

        $book = Book::find($id);

        if (!$book) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'isbn' => ['required', 'max:255'],
            'price' => ['required', 'regex:((^(\d+)(\.?)(\d+)$)|^(\d)$)'],
            'pages' => ['required'],
            'cover_image' => ['nullable', 'max:1024'],
            'description' => ['nullable'],
            'released_at' => ['required', 'date'],
            'in_stock' => ['nullable']
        ]);

        $fields['in_stock'] = $request->has('in_stock');

        if ($request->hasFile('cover_image')) {
            $fields['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $book->update($fields);

        $ids = BookGenre::where('book_id', '=', $id)->get();
        BookGenre::destroy($ids);
        
        $genres = $request->genres;
        if ($genres && is_array($genres)) {

            foreach ($genres as $genreId) {
                try {
                    BookGenre::create([
                        'book_id' => $book->id,
                        'genre_id' => $genreId
                    ]);
                } catch (\Throwable $th) {
                    return redirect('/')->with('message', 'Book Created With Genres Errors!');
                }
            }
        }

        return redirect('/')->with('message', 'Book Updated Successfully!');
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if ($book->cover_image) {
            File::delete(storage_path('app/public/' . $book->cover_image));
        }

        $book->delete();
        return redirect('/')->with('message', 'Book Deleted Successfully!');
    }
}
