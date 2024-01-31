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
        $getCategories = Category::getCategories();
        if($id==""){
            // Add Product
            $title = "Add Product";
        }else{
            // Edit Product
            $title = "Edit Product";
        }

        return view('admin.products.add_edit_product')->with(compact('title','getCategories'));
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
