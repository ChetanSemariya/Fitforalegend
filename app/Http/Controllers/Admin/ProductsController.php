<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductsImage;
use App\Models\{ProductsAttribute, AdminsRole};
use Image;
use Session;
use Auth;

class ProductsController extends Controller
{
    // product listing
    public function products(){
        Session::put('page','products');
        $products = Product::with('category')->orderBy('id','desc')->get()->toArray();
        // dd($products);

        // Set Admin/Subadmin Permission for Products 
        $productsModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'products'])->count();
        $productsModule = [];
        if(Auth::guard('admin')->user()->type == 'admin'){
            $productsModule['view_access']  = 1;
            $productsModule['edit_access']  = 1;
            $productsModule['full_access']  = 1;
        }else if($productsModuleCount ==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $productsModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'products'])->first()->toArray();
        }
        return view('admin.products.products')->with(compact('products','productsModule'));
    }

    // add edit product
    public function addEditProduct(Request $request, $id=null)
    {    
        Session::put('page','products');
        if($id==""){
            // Add Product
            $title = "Add Product";
            $product = new Product;
            $message = 'Product added Successfully!';
        }else{
            // Edit Product
            $title = "Edit Product";
            $product = Product::with(['images','attributes'])->find($id);
            // dd($product);
            $message = 'Product Updated Successfully!';
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // add Product attributes 
            foreach($data['sku'] as $key => $value){
                if(!empty($value)){
                    // SKU already exists check
                    $countSKU = ProductsAttribute::where('sku', $value)->count();
                    if($countSKU>0){
                        $message = "SKU already exists. Please add another SKU";
                        return redirect()->back()->with('success_message', $message);
                    }

                    // Size already exists check
                    $countSize = ProductsAttribute::where(['product_id'=>$id, 'size'=> $data['size'][$key]])->count();
                    if($countSize>0){
                        $message = "Size already exists. Please add another Size";
                        return redirect()->back()->with('success_message', $message);
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $product->id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            // edit product attributes
            foreach($data['attributeId'] as $akey => $attribute){
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$akey]])->update(['price'=>$data['price'][$akey], 'stock'=>$data['stock'][$akey]]);
                }
            }

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
                    $videoPath = "front/videos/products";
                    $video_tmp->move($videoPath, $videoName);
                    // return $videoName;
                    // save video name in products table
                    $product->product_video = $videoName;
                }
            }

            if(!isset($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            $product->category_id      = $data['category_id'];
            $product->product_name     = $data['product_name'];
            $product->product_code     = $data['product_code'];
            $product->product_color    = $data['product_color'];
            $product->family_color     = $data['family_color'];
            $product->group_code       = $data['group_code'];
            $product->product_price    = $data['product_price'];
            $product->product_discount = $data['product_discount'];

            // if discount type is category then it give category discount and if discount type is product then it will be product discount 
            if(!empty($data['product_discount']) && $data['product_discount']>0){
                $product->discount_type = 'product';
                $product->final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
            }else{
                $getCategoryDiscount = Category::select('category_discount')->where('id', $data['category_id'])->first();
                if($getCategoryDiscount->category_discount == 0){
                    $product->discount_type ="";
                    $product->final_price = $data['product_price'];
                }else{
                    $product->discount_type = 'category';
                    $product->final_price = $data['product_price'] - ($data['product_price'] * $getCategoryDiscount->category_discount)/100;
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
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();

            if($id==""){
               $product_id = \DB::getPdo()->lastInsertId();
            }else{
               $product_id = $id;
            }

            // upload product images 
            if($request->hasFile('product_images')){
                $images = $request->file('product_images');
                // echo "<pre>"; print_r($images); die;

                foreach($images as $key => $image){

                    // generate temp images
                    $image_temp = Image::make($image);

                    // get image extension
                    $extension = $image->getClientOriginalExtension();

                    // Generate new image name
                    $imageName = 'product-'.rand(1111, 9999999).'.'.$extension;

                    // Image path for Small, medium and large images
                    $largeImagePath = 'front/images/products/large/'.$imageName;
                    $mediumImagePath = 'front/images/products/medium/'.$imageName;
                    $smallImagePath = 'front/images/products/small/'.$imageName;

                    // Upload the large, medium and small images after resize
                    Image::make($image_temp)->resize(1040,1200)->save($largeImagePath);
                    Image::make($image_temp)->resize(520,600)->save($mediumImagePath);
                    Image::make($image_temp)->resize(260,300)->save($smallImagePath);

                    // Insert Image Name in Product_images table
                    $image = new ProductsImage;
                    $image->image = $imageName;
                    $image->product_id = $product_id;
                    $image->status = 1;
                    $image->save();
                }
            }

            // Sort Product images
            if($id!=""){
                if(isset($data['image'])){
                    foreach($data['image'] as $key => $image){
                        ProductsImage::where(['product_id'=>$id, 'image'=>$image])->update(['image_sort' => $data['image_sort'][$key]]);
                    }
                }
            }
            return redirect('admin/products')->with('success_message', $message);
        }
        
        // get categories and their subcategories
        $getCategories = Category::getCategories();

        // product filters
        $productsFilters = Product::productsFilters();
        return view('admin.products.add_edit_product')->with(compact('title','getCategories','productsFilters', 'product'));
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

    /* -- delete product video -- */
    public function deleteProductVideo($id)
    {
        // get product video 
        $productVideo = Product::select('product_video')->where('id', $id)->first();
       
        // get product video path 
        $product_video_path = 'front/videos/products/';

        // Delete product video from folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete product video name from products table
        Product::where('id', $id)->update(['product_video' => '']);

        $message = "Product Video has been deleted Successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    /* -- delete product images --  */
    public function deleteProductImage($id)
    {
       // get product Image
       $productImage = ProductsImage::select('image')->where('id', $id)->first();

       // get Product image path 
       $small_image_path = 'front/images/products/small/';
       $medium_image_path = 'front/images/products/medium/';
       $large_image_path = 'front/images/products/large/';

       // Delete Product small image if exists in small folder
       if(file_exists($small_image_path.$productImage->image)){
         unlink($small_image_path.$productImage->image);
       }

       // Delete Product medium image if exists in small folder
       if(file_exists($medium_image_path.$productImage->image)){
         unlink($medium_image_path.$productImage->image);
       }
       // Delete Product large image if exists in small folder
       if(file_exists($large_image_path.$productImage->image)){
         unlink($large_image_path.$productImage->image);
       }

       // Delete Product Image from products images table
       ProductsImage::where('id', $id)->delete();

       $message = "Product Image has been deleted Successfully!";
       return redirect()->back()->with('success_message', $message);
    }

     // update product status
     public function updateAttributeStatus(Request $request)
     {
         if($request->ajax()){
             $data = $request->all();
             // echo "<pre>"; print_r($data); die;
             if($data['status']=="Active"){
                 $status = 0;
             }else{
                 $status = 1;
             }
             ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=> $status]);
             return response()->json(['status'=>$status, 'attribute_id'=> $data['attribute_id']]);
         }
     }
 
     // delete category
     public function deleteAttribute($id)
     {
         // return $id;
         ProductsAttribute::where('id', $id)->delete();
         return redirect()->back()->with('success_message', 'Product Attribute Deleted Successfully!');
     }

}
