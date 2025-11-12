<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = auth()->user()->movies()->orderByDesc('watched_at')->get();
        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tmdb_id' => 'required',
            'title' => 'required',
            'poster_path' => 'nullable|string',
            'watched_at' => 'required|date',
            'rating' => 'required|numeric|between:0,5',
        ]);

        $request->user()->movies()->create($data);

        return redirect()->route('movies.index');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movies.index');
    }
}
