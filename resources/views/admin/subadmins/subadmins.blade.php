@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Sub Admins</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Sub Admins</li>
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
            <div class="card-header">
              <h3 class="card-title">Sub Admins</h3>
              <a style="max-width:150px; float:right; display:inline-block;" class="btn btn-block btn-primary" href="{{ url('admin/add-edit-subadmin')}}">Add Subadmins</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="subadmins" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Created on</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subadmins as $subadmin)
                <tr>
                  <td>{{ $subadmin->id}}</td>
                  <td>{{ $subadmin->name}}</td>
                  <td>{{ $subadmin->mobile}}</td>
                  <td>{{ $subadmin->email}}</td>
                  <td>{{ $subadmin->type}}</td>
                  <td>{{ date("F j, Y, g:i a", strtotime($subadmin['created_at']));}}</td>
                  <td>
                    @if($subadmin->status ==1)
                    <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->id }}" subadmin_id="{{ $subadmin->id }}" href="javascript:;void(0)" style='color:#3f6ed3'><i class="fas fa-toggle-on" status="Active"></i>
                    </a>
                    @else
                    <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->id}}" subadmin_id="{{ $subadmin->id}}" style="color:gray" href="javascript:;void(0)"><i class="fas fa-toggle-off" status="Inactive"></i>
                    </a>
                    @endif
                    &nbsp;&nbsp;
                    <a title="Edit Subadmin" href="{{ url('admin/add-edit-subadmin/'.$subadmin->id)}}"><i class="fas fa-edit" style='color:#3f6ed3'></i></a>&nbsp;&nbsp;
                    <a class="confirmDelete" <?php /* href="{{ url('admin/delete-subadmin/'.$page['id'])}}" */ ?> name="Subadmin" href="javascript:void(0)" record="subadmin" recordid="{{ $subadmin->id }}" title="Delete Subadmin"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>&nbsp;&nbsp;
                    <a title="Admin roles" href="{{ url('admin/update-role/'.$subadmin->id)}}"><i class="fas fa-unlock" style='color:#3f6ed3'></i></a>
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