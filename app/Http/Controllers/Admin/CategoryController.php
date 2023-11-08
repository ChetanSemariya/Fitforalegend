<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // $common = [];
        // $common['title'] = 'Categories';
        // Session::put('TopMenu', 'Categories');
        // Session::put('SubMenu', 'Categories');
        // $get_categories_arr = [];

        $get_categories = Category::whereNull('is_delete')
            ->orderby('id', 'asc')
            ->get();

        return view('admin.categories.index', compact('get_categories'));
    }

    public function addCategory(Request $request, $id = '')
    {
        // $common = [];
        // $common['title'] = 'Categories';
        // $common['heding_title'] = 'Add Category';
        // $common['button'] = 'Save';
        // Session::put('TopMenu', 'Categories');
        // Session::put('SubMenu', 'Categories');
        // $get_parent_categories = Category::where('is_parent', 0)->where('status', 'Active')->get();
        // $get_category = getTableColumn('categories');

        if ($request->isMethod('post')) {
            // $data = $request->input();
            // echo "<pre>"; print_r($data); die;
            // $req_fields = [];
            // $req_fields['category_name'] = 'required';
            // if ($request->id != '') {
            //     $req_fields['image'] = 'mimes:jpeg,png,jpg,gif';
            // } else {
            //     $req_fields['image'] = 'required|mimes:jpeg,png,jpg,gif';
            // }

            // $validation = Validator::make(
            //     $request->all(),
            //     $req_fields,
            //     [
            //         'required' => 'The :attribute field is required.',
            //     ],
            // );

            // if ($validation->fails()) {
            //     return back()
            //         ->withErrors($validation)
            //         ->withInput();
            // }

            if ($request->id != '') {
                $message = 'Update Successfully';
                $status = 'success';
                $Category = Category::find($request->id);
            } else {
                $message = 'Add Successfully';
                $status = 'success';
                $Category = new Category();
            }
            $Category->category_name = $request->category_name;
            $Category->status = $request->status;

            if ($request->hasFile('image')) {
                $random_no = Str::random(5);
                $img = $request->file('image');
                $ext = $img->getClientOriginalExtension();
                $new_name = time() . $random_no . '.' . $ext;
                $destinationPath = public_path('uploads/category/');
                $img->move($destinationPath, $new_name);
                $Category->image = $new_name;
            }
            $Category->save();
            return redirect()
                ->route('admin.categories')
                ->withErrors([$status => $message]);
        }

        // if ($id != '') {
        //     if (checkDecrypt($id) == false) {
        //         return redirect()
        //             ->back()
        //             ->withErrors(['error' => 'No Record Found']);
        //     }
        //     $id = checkDecrypt($id);
        //     $common['heding_title'] = 'Edit Category';
        //     $common['button'] = 'Update';
        //     $get_category = Category::where('id', $id)->first();

        //     if (!$get_category) {
        //         return back()->withErrors(['error' => 'Something went wrong']);
        //     }
        // }

        return view('admin.categories.addCategory');
    }
}
