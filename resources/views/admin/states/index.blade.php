@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">{{ $common['title'] }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $common['title'] }}</li>
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
              <h3 class="card-title">{{ $common['title'] }} </h3>
              <a style="max-width:150px; float:right; display:inline-block;" class="btn btn-block btn-primary" href="{{ url('admin/states/add')}}">Add States</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="cmspages" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($get_states as $key => $states)
                <tr>
                  <td>{{ $states['id']}}</td>
                  <td>{{ $states['name']}}</td>
                  <td>
                    <a href="{{ url('admin/states/edit/'.$states['id'])}}"><i class="fas fa-edit"  style='color:#3f6ed3'></i></a>&nbsp;&nbsp;
                    <a class="confirmDelete" name="State Page" href="javascript:void(0)" record="state" recordid="{{ $states['id'] }}" title="Delete States Page"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
     $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr('record');
        var recordid = $(this).attr('recordid');
        // alert(recordid);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              });
              window.location.href ="/admin/delete-"+record+"/"+recordid;
            }
        });
    });
</script>

@endsection  