@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1>{{ $title}}</h1>
              </div>
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">{{ $title}} </li>
                  </ol>
              </div>
          </div>
      </div>
      <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">
          <div class="row">
              <!-- left column -->
              <div class="col-md-12">
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success:</strong> {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                @endif
                  <!-- general form elements -->
                  <div class="card card-primary">
                      <div class="card-header">
                          <h3 class="card-title">{{ $title}}</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      @if ($errors->any())
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                      @endif
                      <form name="categoryForm" id="categoryForm" @if(empty($category['id'])) action="{{ url('admin/add-edit-category')}}" @else action="{{ url('admin/add-edit-category/'.$category['id'])}}" @endif method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group">
                              <label for="category_name">Category Name*</label>
                              <input type="text" name="category_name" id="category_name" class="form-control" @if(!empty($category['category_name'])) value="{{ $category['category_name']}}" @else value="{{ old('category_name')}}" @endif placeholder="Enter category name">
                          </div>
                          <div class="form-group">
                              <label for="category_level">Category Level (Parent Category)*</label>
                              <select name="parent_id" class="form-control">
                                <option value="">Select</option>
                                <option value="0" @if($category['parent_id']==0) selected="" @endif>Main Category</option>
                                @foreach($getCategories as $cat)
                                   <option @if(isset($category['parent_id']) && $category['parent_id']==$cat['id']) selected @endif value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                                   @if(!empty($cat['subcategories']))
                                     @foreach($cat['subcategories'] as $subcat)
                                        <option value="{{ $subcat['id'] }}" @if(isset($category['parent_id']) && $category['parent_id'] == $subcat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subcat['category_name']}}</option>
                                        @if(!empty($subcat['subcategories']))
                                           @foreach($subcat['subcategories'] as $subsubcat)
                                              <option value="{{ $subsubcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subsubcat['category_name']}} </option>
                                           @endforeach
                                        @endif
                                     @endforeach
                                   @endif
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="category_image">Category Image</label>
                            <input type="file" name="category_image" id="category_image" class="form-control">
                            @if(!empty($category['category_image']))
                              <a target="_blank" href="{{ url('front/images/categories/'.$category['category_image'])}}"><img src="{{ asset('front/images/categories/'.$category['category_image']) }}" width="10%" style="margin:10px"></a>
                            <a class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{ $category['id'] }}" title="Delete Category Image"><i style="color:#fff" class="fas fa-trash" style='color:#3f6ed3'></i></a>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="category_discount">Category Discount</label>
                            <input type="text" name="category_discount" id="category_discount"  class="form-control" @if(!empty($category['category_discount'])) value="{{ $category['category_discount']}}" @else value="{{ old('category_discount')}}" @endif placeholder="Enter category discount">
                          </div>
                          <div class="form-group">
                              <label for="url">Category URL*</label>
                              <input type="text" class="form-control" name="url" id="url" @if(!empty($category['url'])) value="{{ $category['url']}}" @else value="{{ old('url')}}" @endif placeholder="Enter Url">
                          </div>
                          <div class="form-group">
                              <label for="description">Category Description</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Category Description">@if(!empty($category['description'])) {{ $category['description']}} @else {{ old('description')}} @endif</textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" id="meta_title" class="form-control" @if(!empty($category['meta_title'])) value="{{ $category['meta_title']}}" @else value="{{ old('meta_title')}}" @endif placeholder="Enter Meta Title">
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" class="form-control"  name="meta_description" id="meta_description"  @if(!empty($category['meta_description'])) value="{{ $category['meta_description']}}" @else value="{{ old('meta_description')}}" @endif placeholder="Enter Meta Description">
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"  @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords']}}" @else value="{{ old('meta_keywords')}}" @endif placeholder="Enter Meta Keywords">
                          </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- /.content -->
</div>
@endsection