<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class FilmController extends Controller
{
    public function index()
    {
        $query = DB::Table('film')
            ->select('*')
            ->join('language', 'film.language_id', '=', 'language.language_id')
            ->join('film_category', 'film.film_id', '=', 'film_category.film_id')
            ->join('category', 'category.category_id', '=', 'film_category.category_id')
            ->join('film_text', 'film_text.film_id', '=', 'film.film_id')
            ->where('film.film_id', 1)
            ->get();

        return DataTables::of($query)->make(true);
    }
}
