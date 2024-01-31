<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    public function index()
    {
        $common = [];
        $common['title'] = "States";
        $get_states = State::get();
        return view('admin.states.index', compact('common', 'get_states'));
    }

    public function addStates(Request $request)
    {
        $common = [];
        $common['title'] = 'States';
        $common['heading_title'] = 'Add States';
        $message = "States Added Successfully!";
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'name' => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $states = new State;
            $states->name = $data['name'];
            $states->save();
            return redirect('admin/states')->with('success_message', $message);
        }
        return view('admin.states.addStates', compact('common'));
    }

    /* -- edit states -- */
    public function editStates(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'States';
        $common['heading_title'] = 'Edit States';
        $message = "States Updated Successfully!";
        $states = State::findOrFail($id);
        
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'name' => 'required|regex:/^[^\d]+$/|min:2|max:255',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $states->name = $data['name'];
            $states->save();
            return redirect('admin/states')->with('success_message', $message);
        }
        return view('admin.states.editStates', compact('common','states'));
    }

    /* -- delete state -- */
    public function deleteState($id)
    {
        $states = State::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'States Deleted Successfully!');
    }
}
