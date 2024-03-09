<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Session;

class BrandController extends Controller
{
    public function brands(Request $request)
    {
        Session::put('page','brands');
        $brands = Brand::get();
        return view('admin.brands.brands', compact('brands'));
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

    // delete category
    public function deleteBrand($id)
    {
        // return $id;
        Brand::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Brand Deleted Successfully!');
    }
}
