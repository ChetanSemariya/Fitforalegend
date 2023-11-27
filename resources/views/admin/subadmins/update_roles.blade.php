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
                      @if(Session::has('error_message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Success:</strong> {{ Session::get('error_message') }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>  
                    @endif
                      <form name="subadminForm" id="subadminForm" action="{{ url('admin/update-role/'.$id)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="subadmin_id" value="{{ $id }}">
                      <div class="card-body">
                        {{-- <div class="form-group col-md-6">
                            <label for="email">Email*</label>
                            <input disabled="" style="background-color: #666666" value="{{ $subadmin['email']}}">
                        </div> --}}
                        <div class="form-group col-md-6">
                            <label for="mobile">CMS Pages: &nbsp;&nbsp;</label>
                            <input type="checkbox" name="cms_pages['view']" value="1">&nbsp;&nbsp; View Access &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="cms_pages['edit']" value="1">&nbsp;&nbsp; View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" name="cms_pages['full']" value="1">&nbsp;&nbsp; Full Access &nbsp;&nbsp;&nbsp;&nbsp;
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