@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1>{{ $common['title'] }}</h1>
              </div>
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">{{ $common['title'] }} </li>
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
                          <h3 class="card-title">{{ $common['heading_title'] }}</h3>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form name="AddressForm" id="AddressForm" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">State*</label>
                              <select class="form-control" id="state" name="state">
                                <option value="">Select State</option>
                                @foreach($get_states as $value)
                                   <option value={{ $value['id'] }} {{ $value['id'] == $address['state_id'] ? 'selected' : ''}}>{{ $value['name'] }}</option>
                                @endforeach
                              </select> 
                              @error('state')
                              <div class="col-form-alert-label">
                                  {{ $message }}
                              </div>
                              @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">City*</label>
                              <select class="form-control" id="city" name="city">
                                <option value="">Select city</option>
                                @foreach($get_cities as $city)
                                   <option value={{ $city['id'] }} {{ $city['id'] == $address['city_id'] ? 'selected' : ''}}>{{ $city['name'] }}</option>
                                @endforeach
                              </select> 
                              @error('city')
                              <div class="col-form-alert-label">
                                  {{ $message }}
                              </div>
                              @enderror
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="name">Name*</label>
                              <input type="text" name="name" id="name" class="form-control" placeholder="Enter City" value="{{ old('name', $address['name'])}}">
                              @error('name')
                              <div class="col-form-alert-label">
                                  {{ $message }}
                              </div>
                              @enderror
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