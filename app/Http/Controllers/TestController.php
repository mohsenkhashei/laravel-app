<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Film;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


class TestController extends Controller
{

    public function index() {
//        $country = CountryModel::all();
//        $country = Country::orderBy('country_id', 'desc')->take(2)->get();
//        foreach($country as $t) {
//            dump($t->country);
//        }
        $film = Film::with('language', 'actors')->first();

        dump($film->title);
        dump(count($film->actors));

        foreach ($film->actors as $actor) {
            dump($actor->actor);
        }
//        dump($film->category);




    }
}
