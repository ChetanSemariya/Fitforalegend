@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Categories</h3>
                <a href="{{ url('admin/addcategories')}}" style="float:right" class="btn btn-primary">Add Categories</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="categories" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Category Image</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($get_categories as $category)
                  <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->category_name}}</td>
                    {{-- <td><img class="tbl-img-css"
                        src="{{ url('assets/uploads/category', $value['image']) }}">
                </td> --}}
                    <td>
                        <img src="{{ url('uploads/categories', $category['image'])}}" class="tbl-img-css"></td>
                    <td>{{ $category->status}}</td>
                    <td>
                        <div class="action_cls mt-2">
                            <a href="#"
                                class="tabledit-edit-button btn btn-success waves-effect waves-light"><i
                                    class="icofont icofont-ui-edit"></i>Edit</a>
                            <a data-href="#"
                                class="tabledit-delete-button btn btn-danger confirm-delete waves-effect waves-light"><i
                                    class="icofont icofont-ui-delete"></i>Delete</a>
                        </div>
                    </td>
                  </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection