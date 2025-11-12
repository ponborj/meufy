<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TMDBController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json(['error' => 'missing query'], 400);
        }

        $pt = Http::withToken(env('TMDB_BEARER_TOKEN'))
            ->get("https://api.themoviedb.org/3/search/movie", [
                'query' => $query,
                'language' => 'pt-BR'
            ])->json();

        $en = Http::withToken(env('TMDB_BEARER_TOKEN'))
            ->get("https://api.themoviedb.org/3/search/movie", [
                'query' => $query,
                'language' => 'en-US'
            ])->json();

        // mescla e remove duplicados
        $merged = collect($pt['results'])->merge($en['results'])->unique('id')->values();

        return response()->json(['results' => $merged]);
    }



    // public function search(Request $request)
    // {
    //     $response = Http::withToken(env('TMDB_BEARER_TOKEN'))
    //         ->get('https://api.themoviedb.org/3/search/movie', [
    //             'query' => $request->query('q')
    //         ]);

    //     return $response->json();
    // }
}