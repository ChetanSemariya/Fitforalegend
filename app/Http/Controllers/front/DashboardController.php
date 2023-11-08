<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Validator;

class DashboardController extends Controller
{
    public function dashboard_front(){
        return view('front.dashboard');
    }

    public function user_login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                "email" => "required|email|max:255",
                "password" => "required|max:30"
            ];

            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required'
            ];

            $validation = Validator::make($request->all(), $rules, $customMessages);

            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $users = new User;
            $users->first_name = $request->first_name;
            $users->last_name = $request->last_name;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);
            $users->confirm_password = $request->password;
            $users->save();

            // $this->validate($request, $rules, $customMessages);
            // if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){
            //     return redirect('admin/dashboard');
            // }else{
            //     return redirect()->back()->with("error_message", "Invalid email or password");
            // }
        }
        return view('front.login');
    }

}
