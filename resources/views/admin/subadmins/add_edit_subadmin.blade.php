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
                      <form name="subadminForm" id="subadminForm" @if(empty($subadmin['id'])) action="{{ url('admin/add-edit-subadmin')}}" @else action="{{ url('admin/add-edit-subadmin/'.$subadmin['id'])}}" @endif method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group col-md-6">
                              <label for="name">Name*</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Subadmin name" @if(!empty($subadmin['name'])) value="{{ $subadmin['name']}}" @endif>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="email">Email*</label>
                              <input type="email" name="email" id="email" class="form-control" placeholder="Enter Subadmin email" @if(!empty($subadmin['email'])) value="{{ $subadmin['email']}}" @endif>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="mobile">Mobile</label>
                              <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile number" @if(!empty($subadmin['mobile'])) value="{{ $subadmin['mobile']}}" @endif>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="mobile">Password</label>
                              <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" @if(!empty($subadmin['password'])) value="{{ $subadmin['password']}}" @endif>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="image">Photo</label>
                            <input type="file" class="form-control" name="image" id="image">
                            @if(!empty($subadmin['image']))
                            <a target="_blank" href="{{ url('admin/images/photos/'.$subadmin['image'])}}">View Photo</a>
                            <input type="hidden" name="current_image" value="{{ $subadmin['image'] }}">
                            @endif
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