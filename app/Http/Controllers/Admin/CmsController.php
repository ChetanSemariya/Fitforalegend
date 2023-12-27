<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'cms-pages');
        $CmsPages = CmsPage::get()->toArray();
        // dd($CmsPages);

        // Set Admin/Subadmin Permission for CMS Pages
        $cmspagesModuleCount = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->count();
        $pagesModule = [];
        if(Auth::guard('admin')->user()->type == 'admin'){
            $pagesModule['view_access']  = 1;
            $pagesModule['edit_access']  = 1;
            $pagesModule['full_access']  = 1;
        }else if($cmspagesModuleCount ==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $pagesModule = AdminsRole::where(['subadmin_id' => Auth::guard('admin')->user()->id, 'module' => 'cms_pages'])->first()->toArray();
        }
        return view('admin.pages.cms_pages')->with(compact('CmsPages', 'pagesModule'));
    }

    // edit cms pages
    public function edit(Request $request, $id="")
    {
        // if($request->isMethod('post')){
            Session::put('page', 'cms-pages'); 
            // return "hello";
            if($id==""){
                $title = "Add CMS Page";
                $cmspage= new CmsPage;
                $message = "CMS Page Added Successfully";
            }else{
                $title = "Edit CMS Page";
                $cmspage = CmsPage::find($id);
                $message = "CMS Page Updated Successfully";
            }
            
            if($request->isMethod('post')){
                $data = $request->all();
                // echo "<pre>"; print_r($data); die;

                $rules = [
                    'title' => 'required',
                    'url' => 'required',
                    'description' => 'required',
                ];
                $customMessages = [
                    'title.required' => 'Title is required',
                    'url.required' => 'Url is required',
                    'description.required' => 'Description is required',
                ];

                $this->validate($request, $rules, $customMessages);

                $cmspage->title = $data['title'];
                $cmspage->url = $data['url'];
                $cmspage->description = $data['description'];
                $cmspage->meta_title = $data['meta_title'];
                $cmspage->meta_description = $data['meta_description'];
                $cmspage->meta_keywords = $data['meta_keywords'];
                $cmspage->status = 1;
                $cmspage->save();
                return redirect('admin/cms-pages')->with('success_message', $message);
            }
            return view('admin.pages.add_edit_cmspage')->with(compact('title','cmspage'));
            // return view('admin.pages.add_edit_cmspage');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where('id',$data['page_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status, 'page_id'=> $data['page_id']]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete CMS Page
        CmsPage::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'CMS Page Deleted Successfully!');
    }
}
