<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Film;
use App\Models\Inventory;
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
        $inventory = Inventory::find($film->film_id);
        dump($inventory->film->title);
        dump($inventory->store->getStaff->first_name);

        dump($film->title);
        dump($film->language->name);
        dump($film->categories->getCategory->name);
        dump($film->text->description);
        dump(count($film->actors));
//
        foreach ($film->actors as $actor) {
            dump($actor->getActor->first_name);
        }
//        dump($film->category);




    }
    public function demo() {}
}
