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
        $film = Film::with('language', 'actors','inventory.store.getStaff')->first();
        $inventory = Inventory::find($film->film_id);
        dump($film);
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

//        $query = \DB::table('student.diploma')
//            ->select(
//                DB::raw("concat(person.p_firstname, ' ', person.p_surname) as full_name"),
//                DB::raw("concat(created_by.p_firstname, ' ', created_by.p_surname) as creator"),
//                DB::raw('date_format(diploma.created_at,\'%d.%m.%Y %H:%i:%s\') as created_at'),
//                'student.st_student_no as student_no',
//                'diploma.diploma_no as diploma_no',
//                'diploma.id as id',
//                'faculty.u_definition_'.getLang().' as faculty',
//                'department.u_definition_'.getLang().' as department'
//            )
//            ->join('definition.term', 'diploma.term_id', '=', 'term.t_id')
//            ->join(
//                'definition.student_program_curriculum as spc',
//                'diploma.student_program_curriculum_id',
//                '=',
//                'spc.sp_id'
//            )
//            ->join('definition.program as program', 'spc.sp_program_id', '=', 'program.pm_id')
//            ->join('definition.unit as department','program.pm_unit_id','=','department.u_id')
//            ->join('definition.unit as faculty','department.u_parent_id','=','faculty.u_id')
//            ->join('definition.student', 'spc.sp_student_id', '=', 'student.st_id')
//            ->join('definition.person', 'student.st_person_id', '=', 'person.p_id')
//            ->leftJoin('definition.person as created_by', 'edited_by', '=', 'created_by.p_id')
//            ->whereRaw($term)
//            ->orderBy('diploma.created_at', 'desc');



//        return Datatables::of($query)
//            ->filterColumn('full_name', function ($query, $keyword) {
//                $keywords = trim($keyword);
//                $query->whereRaw("concat(person.p_firstname, ' ', person.p_surname) like ?", ["%{$keywords}%"]);
//            })->filterColumn('student_no', function ($query, $keyword) {
//                $keywords = trim($keyword);
//                $query->whereRaw("student.st_student_no like ?", ["%{$keywords}%"]);;
//            })->make(true);


    }
    public function demo() {}
}
