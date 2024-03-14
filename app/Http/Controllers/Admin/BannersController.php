<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\AdminsRole;
use Auth;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');

        $banners = Banner::get()->toArray();

        // Set Admin/Subadmin Permission for banners 
        $BannersModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->count();
        $bannerModule = [];
        if(Auth::guard('admin')->user()->type == 'admin'){
            $bannerModule['view_access']  = 1;
            $bannerModule['edit_access']  = 1;
            $bannerModule['full_access']  = 1;
        }else if($BannersModuleCount ==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $bannerModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'banners'])->first()->toArray();
        }
        return view('admin.banners.banner',compact('banners','bannerModule'));
    }

    // add brands
    public function addEditBanner(Request $request, $id=null)
    {
        if($id==""){
            // Add Banner
            $title = "Add Banner";
            $banners = new Banner();
            $message = "Banner Added Successfully!";
        }else{
            // Edit banner
            $title = "Edit Banner";
            // return "hello";
            $banners = Banner::find($id);
            // echo "<pre>"; print_r($banners->toArray()); die;
            $message = "Banner Updated Successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if($id==""){
                $rules = [
                    'banner_type'  => 'required',
                    'banner_image' => 'required|mimes:jpeg,jpg,png,gif',
                ];
            }else{
                $rules = [
                    // 'banner_type' => 'required',
                    'banner_image' => 'mimes:jpeg,jpg,png,gif',
                ];
            }

            $this->validate($request, $rules);

            // Upload Admin Image
            if(isset($request->banner_image)){
                if($request->hasFile('banner_image')){
                    $image_tmp = $request->file('banner_image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                       $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new Image Name
                        $bannerimageName = rand(111,99999).'.'.$extension; 
                        $image_path = 'front/images/banners/'.$bannerimageName;
                        // upload the banners image
                        Image::make($image_tmp)->save($image_path);
                        $banners->image = $bannerimageName;
                    }
                }
            }
            // else{
            //     $brands->brand_image = $brandimageName;
            // }

            $banners->type = $data['banner_type'];
            $banners->link = $data['banner_link'];
            $banners->title = $data['banner_title'];
            $banners->alt = $data['banner_alt'];
            $banners->sort = $data['banner_sort'];
            $banners->status = 1;
            $banners->save();
            return redirect('admin/banners')->with('success_message', $message);
        }
        return view('admin.banners.add_edit_banners')->with(compact('title', 'banners'));
    }

    // update banner status
    public function updateBannerStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'banner_id'=> $data['banner_id']]);
        }
    }

    // delete Banner
    public function deleteBanner($id)
    {
        // get banner Image
        $bannerImage = Banner::where('id',$id)->first();

        // GET banner image path
        $banner_image_path = 'front/images/banners/';

        // Delete banner image if exists in folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        // Delete banner image from banners table
        $bannerImage->delete();
        return redirect()->back()->with('success_message', 'Banner Deleted Successfully!');
    }

}
