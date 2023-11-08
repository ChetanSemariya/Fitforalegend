@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
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
                <h3 class="card-title">Categories</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- <div class="col-md-4">
                        <div class="form-group mb-3 {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="col-form-label">{{('Title')}}<span class="mandatory cls" style="color:red; font-size:15px">*</span></label>
                            <input
                                class="form-control {{ $errors->has('title') ? 'form-control-danger' : '' }}"
                                name="title" type="text"
                                value="{{ old('title', $get_category['title']) }}" placeholder="Enter Title">
                            @error('title')
                                <div class="col-form-alert-label">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                  <div class="form-group">
                    <label for="exampleInputEmail1">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control" placeholder="Enter Category">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Category Image</label>
                    <input type="file" name="image" id="image" class="form-control"  placeholder="Upload Image">
                  </div>
                  {{-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div> --}}
                  <div class="col-md-4">
                    <div class="form-group mb-3 {{ $errors->has('status') ? 'has-danger' : '' }}">
                        <label class="col-form-label">Status</label>
                        <select id="status" name="status" class="form-control stock">
                            <option value="Active">Active</option>
                            {{-- <option value="Deactive"
                                {{ $get_category['status'] == 'Deactive' ? 'selected' : '' }}>Deactive
                            </option> --}}
                        </select>
                        @error('status')
                            <div class="col-form-alert-label">
                                {{ $message }}
                            </div>
                        @enderror
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