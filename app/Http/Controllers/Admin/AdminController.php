<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminsRole;
use Auth;
use Validator;
use Hash;
use Image;
use Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    public function login(Request $request){
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

            $this->validate($request, $rules, $customMessages);
            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])){

                //  Remember Admin Email and password with Cookiess
                if(isset($data['remember']) &&!empty($data['remember'])){
                    setcookie("email",$data['email'], time()+3600);
                    // cookie set for one hour
                    setcookie("password",$data['password'],time()+3600);
                }else{
                    setcookie("email", "");
                    setcookie("password","");
                }
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with("error_message", "Invalid email or password");
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function update_password(Request $request){
        Session::put('page','update-password');
        if($request->isMethod('post')){
            $data = $request->all();
            // Check if current password is correct
            if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
                // Check if new password and confirm password are matching
                if($data['new_pwd'] == $data['confirm_pwd']){
                   // Update new password 
                   Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                   return redirect()->back()->with('success_message', 'Password has been updated Successfully!');
                }else{
                    return redirect()->back()->with('error_message', 'New Password and confirm password must match!');
                }
            }else{
                return redirect()->back()->with('error_message', 'Your Current Password is Incorrect!');
            }
        }
        return view('admin.update_password');
    }

    public function check_current_password(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page','update-details');
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                "admin_name" => "required|regex:/^[\pL\s\-]+$/u|max:255",
                "admin_mobile" => "required|numeric|min:10",
                "admin_image" => "image",
            ];

            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_name.max' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
                'admin_mobile.min' => 'Valid Mobile is required',
                'admin_image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Upload Admin Image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $image_path = 'admin/images/photos/'.$imageName;
                    Image::make($image_tmp)->save($image_path);
                }
            }else if(!empty($data['current_image'])){
                $imageName = $data['current_image'];
            }else{
                $imageName = "";
            }
            
            // update Admin Details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);

            return redirect()->back()->with('success_message', 'Admin Details has been updated Successfully!');
        }
        return view('admin.update_details');
    }

    public function subadmins()
    {
        Session::put('page', 'subadmins');
        $subadmins = Admin::where('type','subadmin')->get();
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }

    public function updateSubadminStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['subadmin_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'subadmin'=> $data['subadmin_id']]);
        }   
    }

    public function addEditSubadmin(Request $request, $id=null)
    {
        // if($request->isMethod('post')){
            Session::put('page', 'subadmins'); 
            // return "hello";
            if($id==""){
                $title = "Add Subadmin";
                $subadmin= new Admin;
                $message = "Subadmin Added Successfully";
            }else{
                $title = "Edit Sub Admin";
                $subadmin = Admin::find($id);
                $message = "Subadmin Updated Successfully";
            }
            
            if($request->isMethod('post')){
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;

                if($id==""){
                    $subadminCount = Admin::where('email', $data['email'])->count();
                    if($subadminCount>0){
                        return redirect()->back()->with('error_message', 'Subadmin already exists!');
                    }
                }

                $rules = [
                    'name' => 'required',
                    'mobile' => 'required|numeric',
                    'image' => 'image'
                ];
                $customMessages = [
                    'name.required' => 'Name is required',
                    'mobile.required' => 'Mobile is required',
                    'mobile.numeric' => 'Valid Mobile is required',
                    'image.image' => 'Valid Image is required',
                ];

                $this->validate($request, $rules, $customMessages);

                  // Upload Admin Image
                if($request->hasFile('image')){
                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $image_path = 'admin/images/photos/'.$imageName;
                        Image::make($image_tmp)->save($image_path);
                    }
                }else if(!empty($data['current_image'])){
                    $imageName = $data['current_image'];
                }else{
                    $imageName = "";
                }

                $subadmin->image = $imageName;
                $subadmin->name = $data['name'];
                $subadmin->mobile = $data['mobile'];
                if($id==""){
                    $subadmin->email = $data['email'];
                    $subadmin->type = 'subadmin';
                }
                if($data['password'] !=""){
                    $subadmin->password = Hash::make($data['password']);
                }
                $subadmin->status = 1;
                $subadmin->save();
                return redirect('admin/subadmins')->with('success_message', $message);
            }
            return view('admin.subadmins.add_edit_subadmin')->with(compact('title','subadmin'));
            // return view('admin.pages.add_edit_subadmin');
    }

    public function deleteSubadmin($id)
    {
        // Delete Subadmin
        Admin::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin Deleted Successfully!');
    }

    public function updateRole($id, Request $request)
    {
        // return $id;
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // make dynamic roles with help of foreach 
            foreach($data as $key => $value){
                if(isset($value['view'])){
                    $view = $value['view'];
                }else{
                    $view = 0;
                }

                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }
                if(isset($value['full'])){
                    $full = $value['full'];
                }else{
                    $full = 0;
                }
            }

            // Delete all earlier roles for subadmins
            AdminsRole::where('subadmin_id', $id)->delete();

            // Add new roles for subadmin
            // if(isset($data['cms_pages']['view'])){
            //     $cms_pages_view = $data['cms_pages']['view'];
            // }else{
            //     $cms_pages_view = 0;
            // }

            // if(isset($data['cms_pages']['edit'])){
            //     $cms_pages_edit = $data['cms_pages']['edit'];
            // }else{
            //     $cms_pages_edit = 0;
            // }

            // if(isset($data['cms_pages']['full'])){
            //     $cms_pages_full = $data['cms_pages']['full'];
            // }else{
            //     $cms_pages_full = 0;
            // }

            $role = new AdminsRole;
            $role->subadmin_id = $id;
            $role->module = $key;
            $role->view_access = $view;
            // return $role;
            $role->edit_access = $edit;
            $role->full_access = $full;
            // echo "<pre>"; print_r($role->toArray()); die;
            $role->save();

            $message = "Subadmin Roles Updated Successfully!";
            return redirect()->back()->with('success_message', $message);
        }

        $subadminRoles = AdminsRole::where('subadmin_id', $id)->get()->toArray();
        $subadminDetails = Admin::where('id', $id)->first()->toArray();
        $title = "Update ".$subadminDetails['name']." Subadmin Roles/Permission";
        // dd($subadminRoles);
        return view('admin.subadmins.update_roles')->with(compact('title', 'id','subadminRoles'));
    }
}
