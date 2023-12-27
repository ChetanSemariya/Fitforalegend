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
                              <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name')}}" placeholder="Enter category name">
                          </div>
                          <div class="form-group">
                              <label for="category_image">Category Image</label>
                              <input type="file" name="category_image" id="category_image" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="category_discount">Category Discount</label>
                            <input type="text" name="category_discount" id="category_discount" value="{{ old('category_discount')}}" class="form-control" placeholder="Enter category discount">
                          </div>
                          <div class="form-group">
                              <label for="url">Category URL*</label>
                              <input type="text" name="url" id="url" value="{{ old('url')}}" class="form-control" placeholder="Enter Url">
                          </div>
                          <div class="form-group">
                              <label for="description">Category Description</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description">{{ old('description')}}</textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title')}}" placeholder="Enter Meta Title">
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" name="meta_description" id="meta_description" value="{{ old('meta_description')}}"  class="form-control" placeholder="Enter Meta Description">
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" value="{{ old('meta_keywords')}}" id="meta_keywords" class="form-control" placeholder="Enter Meta Keywords">
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