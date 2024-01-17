<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\AdminsRole;
use Auth;
use Image;
use DB;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with('parentcategory')->get();
        // dd($categories->toArray());

        // Set Admin/Subadmin Permission for Categories 
        $CategoriesModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->count();
        $categoriesModule = [];
        if(Auth::guard('admin')->user()->type == 'admin'){
            $categoriesModule['view_access']  = 1;
            $categoriesModule['edit_access']  = 1;
            $categoriesModule['full_access']  = 1;
        }else if($CategoriesModuleCount ==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $categoriesModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'categories'])->first()->toArray();
        }
        return view('admin.categories.categories')->with(compact('categories','categoriesModule'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'category_id'=> $data['category_id']]);
        }
    }

    // delete category
    public function deleteCategory($id)
    {
        // return $id;
        Category::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Category Deleted Successfully!');
    }

    public function addEditCategory(Request $request, $id=null)
    {
        $getCategories = Category::getCategories();
        if($id==""){
            // Add Category
            $title = "Add Category";
            $category = new Category();
            $message = "Category Added Successfully!";
        }else{
            // Edit Category
            $title = "Edit Category";
            // return "hello";
            $category = Category::find($id);
            $message = "Category Updated Successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if($id==""){
                $rules = [
                    'category_name' => 'required',
                    'url' => 'required|unique:categories',
                ];
            }else{
                $rules = [
                    'category_name' => 'required',
                    'url' => 'required',
                ];
            }

            $customMessages = [
                'category_name.required' => 'Category name is required',
                'url.required' => 'Category URL is required',
                'url.unique' => 'Unique URL is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Upload Admin Image
            if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                   $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new Image Name
                    $imageName = rand(111,99999).'.'.$extension; 
                    $image_path = 'front/images/categories/'.$imageName;
                    // upload the category image
                    Image::make($image_tmp)->save($image_path);
                    $category->category_image = $imageName;
                }
            }
            else{
                $category->category_image = "";
            }

            if(empty($data['category_discount'])){
                $data['category_discount'] = 0;
            }
            
            $category->category_name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->category_discount = $data['category_discount'];
            $category->url = $data['url'];
            $category->description = $data['description'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();
            return redirect('admin/categories')->with('success_message', $message);
        }
        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getCategories'));
    }

    public function deleteCategoryImage($id)
    {
        // return $id;
        // get the category image 
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        // get image path
        $category_image_path = 'front/images/categories/';

        // delete category image from categories folder if exists 
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        // delete category image from table
        Category::where('id', $id)->update(['category_image'=>'']);
        return redirect()->back()->with('success_message', 'Category Image Deleted Successfully!');
    }
}
