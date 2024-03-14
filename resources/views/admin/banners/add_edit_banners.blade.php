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
                      <form name="BannerForm" id="BannerForm" @if(empty($banners['id'])) action="{{ url('admin/add-edit-banner')}}" @else action="{{ url('admin/add-edit-banner/'.$banners['id'])}}" @endif method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_type">Banner Type</label>
                                    <select class="form-control" name="banner_type" id="banner_type">
                                        <option value="">Select</option>
                                        <option @if(!empty($banners['type']) && $banners['type'] == "Slider") selected @endif value="Slider">Slider</option>
                                        <option @if(!empty($banners['type']) && $banners['type'] == "Fix 1") selected @endif value="Fix 1">Fix 1</option>
                                        <option @if(!empty($banners['type']) && $banners['type'] == "Fix 2") selected @endif value="Fix 2">Fix 2</option>
                                        <option @if(!empty($banners['type']) && $banners['type'] == "Fix 3") selected @endif value="Fix 3">Fix 3</option>
                                        <option @if(!empty($banners['type']) && $banners['type'] == "Fix 4") selected @endif value="Fix 4">Fix 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="banner_image">Banner Image</label>
                                  <input type="file" name="banner_image" id="banner_image" class="form-control">
                                  @if(!empty($banners['image']))
                                    <a target="_blank" href="{{ url('front/images/banners/'.$banners['image'])}}"><img src="{{ asset('front/images/banners/'.$banners['image']) }}" width="15%" style="margin:10px"></a>
                                  @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="banner_link">Brand Link</label>
                                  <input type="text" name="banner_link" id="banner_link"  class="form-control" @if(!empty($banners['link'])) value="{{ $banners['link']}}" @else value="{{ old('banner_link')}}" @endif placeholder="Enter Banner Link">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_title">Banner Title*</label>
                                    <input type="text" class="form-control" name="banner_title" id="banner_title" @if(!empty($banners['title'])) value="{{ $banners['title']}}" @else value="{{ old('banner_title')}}" @endif placeholder="Enter Banner Title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_alt">Banner Alt</label>
                                    <input type="text" name="banner_alt" id="banner_alt" class="form-control" @if(!empty($banners['alt'])) value="{{ $banners['alt']}}" @else value="{{ old('banner_alt')}}" @endif placeholder="Enter Banner Alt">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="banner_sort">Banner Sort</label>
                                    <input type="number" name="banner_sort" id="banner_sort" class="form-control"  @if(!empty($banners['sort'])) value="{{ $banners['sort']}}" @else value="{{ old('banner_sort')}}" @endif placeholder="Enter Banner Sort">
                                </div>
                            </div>
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