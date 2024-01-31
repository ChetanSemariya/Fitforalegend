<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\{City, State, Address};

class AddressController extends Controller
{
    public function index()
    {
        $common = [];
        $common['title'] = "Address";
        $get_address = Address::get();
        return view('admin.address.index', compact('common', 'get_address'));
    }

    // add address
    public function addAddress(Request $request)
    {
        $common = [];
        $common['title'] = 'Address';
        $common['heading_title'] = 'Add Address';
        $message = "Address Added Successfully!";

        $get_states = State::get();
        $get_cities = City::get();
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;
            
            $rules = [
                'name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'state'  => 'required',
                'city'   => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $address = new Address;
            $address->state_id = $data['state'];
            $address->city_id = $data['city'];
            $address->name  = $data['name'];
            $address->save();
            return redirect('admin/address')->with('success_message', $message);
        }
        return view('admin.address.addAddress', compact('common','get_states','get_cities'));
    }

    // edit address
    public function editAddress(Request $request, $id)
    {
        $common = [];
        $common['title'] = 'Address';
        $common['heading_title'] = 'Edit Address';
        $address = Address::findOrFail($id);
        $message = "Address Updated Successfully!";

        $get_states = State::get();
        $get_cities = City::get();
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;
            
            $rules = [
                'name'   => 'required|regex:/^[^\d]+$/|min:2|max:255',
                'state'  => 'required',
                'city' => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }

            $address->state_id = $data['state'];
            $address->city_id = $data['city'];
            $address->name  = $data['name'];
            $address->save();
            return redirect('admin/address')->with('success_message', $message);
        }
        return view('admin.address.editAddress', compact('common','address','get_states','get_cities'));
    }

    /* -- delete address -- */
    public function deleteAddress($id)
    {
        $address = Address::findOrFail($id)->delete();
        return redirect()->back()->with('success_message', 'Address Deleted Successfully!');
    }
}
