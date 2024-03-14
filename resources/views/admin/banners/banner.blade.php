@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains brand content -->
<div class="content-wrapper">
  <!-- Content Header (brand header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Banners</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Banners</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

   <!-- Main content -->
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          @if(Session::has('success_message'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success:</strong> {{ Session::get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>  
        @endif
          <div class="card">
           @if($bannerModule['edit_access'] ==1 || $bannerModule['full_access'] ==1)
            <div class="card-header">
              <h3 class="card-title">Banners</h3>
              <a style="max-width:150px; float:right; display:inline-block;" class="btn btn-block btn-primary" href="{{ url('admin/add-edit-banner')}}">Add Banners</a>
            </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
              <table id="banners" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Type</th>
                  <th>Link</th>
                  <th>Title</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banners as $banner)
                <tr>
                  <td>{{ $banner['id']}}</td>
                  <td><a target="_blank" href="{{ url('front/images/banners/'.$banner['image'])}}"><img class="rounded-circle" src="{{ asset('front/images/banners/'.$banner['image'])}}" width="60px" height="60px"></a></td>
                  <td>{{ $banner['type']}}</td>
                  <td>{{ $banner['link']}}</td>
                  <td>{{ $banner['title']}}</td>
                  <td>
                    @if($bannerModule['edit_access'] ==1 || $bannerModule['full_access'] ==1) 
                      @if($banner['status'] ==1)
                      <a class="updateBannerStatus" id="banner-{{ $banner['id']}}" banner_id="{{ $banner['id'] }}" href="javascript:;void(0)" style='color:#3f6ed3'><i class="fas fa-toggle-on" status="Active"></i>
                      </a>
                      @else
                      <a class="updateBannerStatus" id="banner-{{ $banner['id']}}" banner_id="{{ $banner['id']}}" style="color:gray" href="javascript:;void(0)"><i class="fas fa-toggle-off" status="Inactive"></i>
                      </a>
                      @endif
                      &nbsp;&nbsp;
                    @endif
                    @if($bannerModule['edit_access'] ==1 || $bannerModule['full_access'] ==1) 
                      <a href="{{ url('admin/add-edit-banner/'.$banner['id'])}}" title="Edit Banner"><i class="fas fa-edit"  style='color:#3f6ed3'></i></a>&nbsp;&nbsp;
                    @endif
                    @if($bannerModule['full_access'] == 1)
                      <a class="confirmDelete" href="javascript:void(0)" record="banner" recordid="{{ $banner['id'] }}" title="Delete Banner"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>
                    @endif
                </td>
                </tr>
                @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection  