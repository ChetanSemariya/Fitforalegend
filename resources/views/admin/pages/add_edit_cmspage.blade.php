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
                      <form name="cmsForm" id="cmsForm" @if(empty($cmspage['id'])) action="{{ url('admin/add-edit-cms-page')}}" @else action="{{ url('admin/add-edit-cms-page/'.$cmspage['id'])}}" @endif method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group">
                              <label for="title">Title*</label>
                              <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" @if(!empty($cmspage['title'])) value="{{ $cmspage['title']}}" @endif>
                          </div>
                          <div class="form-group">
                              <label for="url">URL*</label>
                              <input type="text" name="url" id="url" class="form-control" placeholder="Enter Page Url" @if(!empty($cmspage['url'])) value="{{ $cmspage['url']}}" @endif>
                          </div>
                          {{-- @error('url')
                          <div class="col-form-alert-label">
                              {{ $message }}
                          </div>
                          @enderror --}}
                          <div class="form-group">
                              <label for="description">Description*</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description"> @if(!empty($cmspage['description'])) {{ $cmspage['description']}} @endif</textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta Title" @if(!empty($cmspage['meta_title'])) value="{{ $cmspage['meta_title']}}" @endif>
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" name="meta_description" id="meta_description" class="form-control" placeholder="Enter Meta Description"  @if(!empty($cmspage['meta_description'])) value="{{ $cmspage['meta_description']}}" @endif>
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Enter Meta Keywords"  @if(!empty($cmspage['meta_keywords'])) value="{{ $cmspage['meta_keywords']}}" @endif>
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