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
                      <form name="BrandDetailsForm" id="BrandDetailsForm" @if(empty($brands['id'])) action="{{ url('admin/add-edit-brand')}}" @else action="{{ url('admin/add-edit-brand/'.$brands['id'])}}" @endif method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group">
                              <label for="brand_name">Brand Name*</label>
                              <input type="text" name="brand_name" id="brand_name" class="form-control" @if(!empty($brands['brand_name'])) value="{{ $brands['brand_name']}}" @else value="{{ old('brand_name')}}" @endif placeholder="Enter Brand name">
                          </div>
                          <div class="form-group">
                            <label for="brand_image">Brand Image</label>
                            <input type="file" name="brand_image" id="brand_image" class="form-control">
                            @if(!empty($brands['brand_image']))
                              <a target="_blank" href="{{ url('front/images/brands/'.$brands['brand_image'])}}"><img src="{{ asset('front/images/brands/'.$brands['brand_image']) }}" width="10%" style="margin:10px"></a>
                            <a class="confirmDelete" href="javascript:void(0)" record="brand-image" recordid="{{ $brands['id'] }}" title="Delete Brands Image"><i style="color:#fff" class="fas fa-trash" style='color:#3f6ed3'></i></a>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="brand_logo">Brand Logo</label>
                            <input type="file" name="brand_logo" id="brand_logo" class="form-control">
                            @if(!empty($brands['brand_logo']))
                              <a target="_blank" href="{{ url('front/images/brands/'.$brands['brand_logo'])}}"><img src="{{ asset('front/images/brands/'.$brands['brand_logo']) }}" width="10%" style="margin:10px"></a>
                            <a class="confirmDelete" href="javascript:void(0)" record="brand-logo" recordid="{{ $brands['id'] }}" title="Delete Brands Logo"><i style="color:#fff" class="fas fa-trash" style='color:#3f6ed3'></i></a>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="brand_discount">Brand Discount</label>
                            <input type="text" name="brand_discount" id="brand_discount"  class="form-control" @if(!empty($brands['brand_discount'])) value="{{ $brands['brand_discount']}}" @else value="{{ old('brand_discount')}}" @endif placeholder="Enter Brand discount">
                          </div>
                          <div class="form-group">
                              <label for="url">URL*</label>
                              <input type="text" class="form-control" name="url" id="url" @if(!empty($brands['url'])) value="{{ $brands['url']}}" @else value="{{ old('url')}}" @endif placeholder="Enter Url">
                          </div>
                          <div class="form-group">
                              <label for="description">Brand Description</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description">@if(!empty($brands['description'])) {{ $brands['description']}} @else {{ old('description')}} @endif</textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" id="meta_title" class="form-control" @if(!empty($brands['meta_title'])) value="{{ $brands['meta_title']}}" @else value="{{ old('meta_title')}}" @endif placeholder="Enter Meta Title">
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" class="form-control"  name="meta_description" id="meta_description"  @if(!empty($brands['meta_description'])) value="{{ $brands['meta_description']}}" @else value="{{ old('meta_description')}}" @endif placeholder="Enter Meta Description">
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"  @if(!empty($brands['meta_keywords'])) value="{{ $brands['meta_keywords']}}" @else value="{{ old('meta_keywords')}}" @endif placeholder="Enter Meta Keywords">
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