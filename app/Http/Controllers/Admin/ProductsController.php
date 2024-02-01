<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    // product listing
    public function products(){
        $products = Product::with('category')->get()->toArray();
        // dd($products);
        return view('admin.products.products')->with(compact('products'));
    }

    // add edit product
    public function addEditProduct(Request $request, $id=null)
    {
        if($id==""){
            // Add Product
            $title = "Add Product";
            $product = new Product;
            $productdata = array();
            $message = 'Product added Successfully!';
        }else{
            // Edit Product
            $title = "Edit Product";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // product validation 
            $rules = [
                'category_id'   => 'required',
                'product_name'  => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'product_code'  => 'required|regex:/^[\w-]*$/|max:30',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:200',
                'family_color'  => 'required|regex:/^[\pL\s\-]+$/u|max:200'
            ];

            $customMessages = [
                'category_id.required'   => 'Category Id is required',
                'product_name.required'  => 'Product name is required',
                'product_name.regex'     => 'Valid Product name is required',
                'product_code.required'  => 'Product Code is required',
                'product_code.regex'     => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric'  => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex'    => 'Valid Product Color is required',
                'family_color.required'  => 'Family Color is required',
                'family_color.regex'     => 'Valid Family Color is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // upload product video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    // upload video
                    // $videoName = $video_tmp->getClientOriginalName();
                    $videoExtension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand().'.'.$videoExtension;
                    $videoPath = "front/videos/";
                    $video_tmp->move($videoPath, $videoName);
                    // return $videoName;
                    // save video name in products table
                    $product->product_video = $videoName;
                }
            }

            if(!isset($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->family_color = $data['family_color'];
            $product->group_code = $data['group_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];

            if(!empty($data['product_discount']) && $data['product_discount']>0){
                $product->discount_type = 'product';
                $product->final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
            }else{
                $getCategoryDiscount = Category::select('category_discount')->where('id', $data['category_id'])->first();
                if($getCategoryDiscount->category_discount == 0){
                    $product->discount_type ="";
                    $product->final_price = $data['product_price'];
                }
            }
            $product->product_weight = $data['product_weight'];
            $product->fabric = $data['fabric'];
            $product->sleeve = $data['sleeve'];
            $product->pattern = $data['pattern'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->search_keywords = $data['search_keywords'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_features = "No";
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/products')->with('success_message', 'Product Added Successfully!');
        }
        
        // get categories and their subcategories
        $getCategories = Category::getCategories();

        // product filters
        $productsFilters = Product::productsFilters();
        return view('admin.products.add_edit_product')->with(compact('title','getCategories','productsFilters'));
    }

    // update product status
    public function updateProductStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'product_id'=> $data['product_id']]);
        }
    }

    // delete category
    public function deleteProduct($id)
    {
        // return $id;
        Product::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Product Deleted Successfully!');
    }

}
