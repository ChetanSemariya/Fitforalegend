<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\AdminsRole;
use Auth;
use Session;
use Image;

class BrandController extends Controller
{
    public function brands(Request $request)
    {
        Session::put('page','brands');
        $brands = Brand::get();

        // Set Admin/Subadmin Permission for Categories 
        $BrandsModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->count();
        $brandsModule = [];
        if(Auth::guard('admin')->user()->type == 'admin'){
            $brandsModule['view_access']  = 1;
            $brandsModule['edit_access']  = 1;
            $brandsModule['full_access']  = 1;
        }else if($BrandsModuleCount ==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $brandsModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'brands'])->first()->toArray();
        }
        return view('admin.brands.brands', compact('brands','brandsModule'));
    }

    // add brands
    public function addEditBrand(Request $request, $id=null)
    {
        if($id==""){
            // Add Brand
            $title = "Add Brand";
            $brands = new Brand();
            $message = "Brand Added Successfully!";
        }else{
            // Edit brand
            $title = "Edit Category";
            // return "hello";
            $brands = Brand::find($id);
            $message = "Brand Updated Successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if($id==""){
                $rules = [
                    'brand_name' => 'required',
                    'url'        => 'required|unique:brands',
                ];
            }else{
                $rules = [
                    'brand_name' => 'required',
                    'url'        => 'required',
                ];
            }

            $customMessages = [
                'brand_name.required' => 'Brand name is required',
                'url.required'        => 'Brand URL is required',
                'url.unique'          => 'Unique URL is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Upload Admin Image
            if(isset($request->brand_image)){
                if($request->hasFile('brand_image')){
                    $image_tmp = $request->file('brand_image');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                       $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new Image Name
                        $brandimageName = rand(111,99999).'.'.$extension; 
                        $image_path = 'front/images/brands/'.$brandimageName;
                        // upload the category image
                        Image::make($image_tmp)->save($image_path);
                        $brands->brand_image = $brandimageName;
                    }
                }
            }
            // else{
            //     $brands->brand_image = $brandimageName;
            // }

            // Upload Brand Logo
            if(isset($request->brand_logo)){

                if($request->hasFile('brand_logo')){
                    $image_tmp = $request->file('brand_logo');
                    if($image_tmp->isValid()){
                        // Get Image Extension
                       $extension = $image_tmp->getClientOriginalExtension();
                        // Generate new Image Name
                        $logoimageName = rand(111,99999).'.'.$extension; 
                        $image_path = 'front/images/brands/'.$logoimageName;
                        // upload the category image
                        Image::make($image_tmp)->save($image_path);
                        $brands->brand_logo = $logoimageName;
                    }
                }
            }
            // else{
            //     $brands->brand_logo = $logoimageName;
            // }

            // Remove Brand Discount from all products belongs to specific Brand
            if(empty($data['brand_discount'])){
                $data['brand_discount'] = 0;
                if($id!=""){
                    $brandProducts = Product::where('brand_id', $id)->get()->toArray();
                    foreach($brandProducts as $key => $product){
                        if($product['discount_type'] == "brand"){
                            Product::where('id',$product['id'])->update(['discount_type'=>'', 'final_price'=>$product['product_price']]);
                        }
                    }
                }
            }
            
            $brands->brand_name = $data['brand_name'];
            $brands->brand_discount = $data['brand_discount'];
            $brands->url = $data['url'];
            $brands->description = $data['description'];
            $brands->meta_title = $data['meta_title'];
            $brands->meta_description = $data['meta_description'];
            $brands->meta_keywords = $data['meta_keywords'];
            $brands->status = 1;
            $brands->save();
            return redirect('admin/brands')->with('success_message', $message);
        }
        return view('admin.brands.add_edit_brands')->with(compact('title', 'brands'));
    }

    // delete brand image
    public function deleteBrandImage($id)
    {
        // return $id;
        // get the category image 
        $BrandImage = Brand::select('brand_image')->where('id', $id)->first();

        // get image path
        $brand_image_path = 'front/images/brands/';

        // delete category image from categories folder if exists 
        if(file_exists($brand_image_path.$BrandImage->brand_image)){
            unlink($brand_image_path.$BrandImage->brand_image);
        }

        // delete brand image from table
        Brand::where('id', $id)->update(['brand_image'=>'']);
        return redirect()->back()->with('success_message', 'Brand Image Deleted Successfully!');
    }


    // delete logo image
    public function deleteBrandLogo($id)
    {
        // return $id;
        // get the category image 
        $BrandLogo = Brand::select('brand_logo')->where('id', $id)->first();

        // get image path
        $brand_logo_path = 'front/images/brands/';

        // delete category image from categories folder if exists 
        if(file_exists($brand_logo_path.$BrandLogo->brand_logo)){
            unlink($brand_logo_path.$BrandLogo->brand_logo);
        }

        // delete brand image from table
        Brand::where('id', $id)->update(['brand_logo'=>'']);
        return redirect()->back()->with('success_message', 'Brand Logo Deleted Successfully!');
    }


    // update product status
    public function updateBrandStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'brand_id'=> $data['brand_id']]);
        }
    }

    // delete Brand
    public function deleteBrand($id)
    {
        // return $id;
        Brand::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Brand Deleted Successfully!');
    }
}
