<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{City, State};

class CityController extends Controller
{
    public function index()
    {
        $common = [];
        $common['title'] = "Cities";
        $get_cities = City::get();
        return view('admin.cities.index', compact('common', 'get_cities'));
    }

    // add cities
    public function addCity(Request $request)
    {
        $common = [];
        $common['title'] = 'Cities';
        $common['heading_title'] = 'Add Cities';
        $message = "Cities Added Successfully!";

        $get_states = State::get();
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;
            
            $rules = [
                'name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'state'  => 'required'
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $cities = new City;
            $cities->state_id = $data['state'];
            $cities->name  = $data['name'];
            $cities->save();
            return redirect('admin/cities')->with('success_message', $message);
        }
        return view('admin.cities.addCities', compact('common','get_states'));
    }

    // edit cities
    public function editCity(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'Cities';
        $common['heading_title'] = 'Edit Cities';
        $cities = City::findOrFail($id);
        $message = "Cities Updated Successfully!";

        $get_states = State::get();
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;
            
            $rules = [
                'name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'state'  => 'required'
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $cities->state_id = $data['state'];
            $cities->name  = $data['name'];
            $cities->save();
            return redirect('admin/cities')->with('success_message', $message);
        }
        return view('admin.cities.editCities', compact('common','cities','get_states'));
    }

    /* -- delete city -- */
    public function deleteCity($id)
    {
        $city = City::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'City Deleted Successfully!');
    }
}
