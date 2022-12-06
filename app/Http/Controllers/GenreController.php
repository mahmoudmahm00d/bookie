<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index()
    {
        $genres = Genre::all();
        return view('genres.index', ['genres' => $genres]);
    }

    public function create()
    {
        return view('genres.create');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'max:255', 'unique:genres']
        ]);

        Genre::create($fields);

        return redirect('/genres')->with('Genre Created Successfully!');
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            throw new NotFoundHttpException();
        }

        return view('genres.show', ['genre', $genre]);
    }

    public function edit($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            throw new NotFoundHttpException();
        }

        return view('genres.edit', ['genre' => $genre]);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'name' => ['required', 'max:255']
        ]);

        $genre->update($fields);

        return redirect('/genres')->with('Genre Updated Successfully!');
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            throw new NotFoundHttpException();
        }

        $genre->delete();
        return redirect('/genres')->with('Genre Deleted Successfully!');
    }
}
