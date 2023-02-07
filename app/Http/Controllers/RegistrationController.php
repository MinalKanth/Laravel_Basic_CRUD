<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Registration;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class RegistrationController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $registrations = Registration::orderBy('id','desc')->paginate(5);
        return view('index', compact('registrations','countries'));

    }

    function get()
    {
        $countries = Country::all();

//        return response()->json(DB::select("select * from registrations order by id DESC") );
        return response()->json(DB::select("SELECT registrations.*, countries.name as country, states.name as state, cities.name as city
		 from registrations
		 Inner join countries on registrations.country = countries.id
		 Inner join states on registrations.state= states.id
		 Inner join cities on registrations.city = cities.id
              ") );
    }
    function edit(Request $req)
    {
        return response()->json(DB::selectOne("select * from registrations where id = ?", [$req->post('id')]) );
    }

    function del(Request $req)
    {
        return response()->json(DB::delete("delete from registrations where id = ?", [$req->post('id')]) > 0);
    }

    function save(Request $req)
    {
        $name = $req->post("name");
        $dob = $req->post("dob");
        $des = $req->post("des");
        $qua = $req->post("qua");
        $gender = $req->post("gender");
        $email = $req->post("email");
        $loc = $req->post("loc");
        $mo = $req->post("mo");
        $country = $req->post("country");
        $state = $req->post("state");
        $city = $req->post("city");
        $id = $req->post("id");

        if($id != "" && ((int)$id) > 0)
        {
            return response()->json(DB::update("update registrations set
                name=?,dob=?,des=?,qua=?,gender=?,email=?,loc=?,mo=?,country=?,state=?,city=?
                where id = ?", [$name,$dob,$des,$qua,$gender,$email,$loc,$mo,$id]) > 0);
        }
        else
        {
            return response()->json(DB::insert("Insert into registrations
                (name,dob,des,qua,gender,email,loc,mo,country,state,city)
                values(?,?,?,?,?,?,?,?,?,?,?)", [$name,$dob,$des,$qua,$gender,$email,$loc,$mo,$country,$state,$city]) > 0);
        }
    }
    function state_by_country(Request $req)
    {
        $countries = Country::get()->toArray();
        if (isset($request->county)) {
            $cities = Country::where('id', $request->county)->with('multipleCities')->first();
            $cities = $cities->multipleCities;

        }

//       $data = State::get(where country_id = $req)->toArray();
//////        $data = Country::get()->toArray();
        echo "<pre>";
        print_r($cities);
        exit;
////        return response()->json(DB::select("select * from State where country_id = ?", [$req->get('country_id')]) );

    }
//    public function getBrandsManyData(Request $request)
//    {
//        $data = Brands::with('manyDealers')->get()->toArray();
//        echo "<pre>";
//        print_r($data);
//        exit;
//        return true;
//    }
    public function viewMultipleCities(Request $request)
    {
        $cities = new \stdClass();
        $countries = Country::get();
        if (isset($request->county)) {
            $cities = Country::where('id', $request->county)->with('multipleCities')->first();
            $cities = $cities->multipleCities;
        }
        return view('has_many_through', compact('countries', 'cities'));
    }
    public function fatchState(Request $request)
    {
        $data['states'] = State::where('country_id',$request->country_id)->get(['name','id']);

        return response()->json($data);
    }

    public function fatchCity(Request $request)
    {
        $data['cities'] = City::where('state_id',$request->state_id)->get(['name','id']);

        return response()->json($data);
    }

}
