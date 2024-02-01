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
                      <form name="productForm" id="productForm" @if(empty($product['id'])) action="{{ url('admin/add-edit-product')}}" @else action="{{ url('admin/add-edit-product/'.$product['id'])}}" @endif method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="card-body">
                          <div class="form-group">
                              <label for="category_id">Select Category*</label>
                              <select name="category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($getCategories as $cat)
                                   <option @if(!empty(@old('category_id')) && $cat['id']== @old('category_id')) selected="" @endif value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                                   @if(!empty($cat['subcategories']))
                                     @foreach($cat['subcategories'] as $subcat)
                                        <option @if(!empty(@old('category_id')) && $subcat['id']== @old('category_id')) selected="" @endif  value="{{ $subcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subcat['category_name']}}</option>
                                        @if(!empty($subcat['subcategories']))
                                           @foreach($subcat['subcategories'] as $subsubcat)
                                              <option @if(!empty(@old('category_id')) && $subsubcat['id']== @old('category_id')) selected="" @endif value="{{ $subsubcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subsubcat['category_name']}} </option>
                                           @endforeach
                                        @endif
                                     @endforeach
                                   @endif
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="product_name">Product Name*</label>
                            <input type="text" name="product_name" id="product_name"  class="form-control" placeholder="Enter Product Name"  value="{{ @old('product_name')}}">
                          </div>
                          <div class="form-group">
                            <label for="product_code">Product Code*</label>
                            <input type="text" name="product_code" id="product_code"  class="form-control" value="{{ old('product_code')}}" placeholder="Enter Product Code">
                          </div>
                          <div class="form-group">
                            <label for="product_color">Product Color*</label>
                            <input type="text" name="product_color" id="product_color"  class="form-control" value="{{ old('product_color')}}" placeholder="Enter Product Color">
                          </div>
                          <div class="form-group">
                            <label for="family_color">Family Color*</label>
                            <select class="form-control" value="{{ old('family_color')}}" name="family_color">
                                <option value="">Select</option>
                                <option value="Red">Red</option>
                                <option value="Green">Green</option>
                                <option value="Yellow">Yellow</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Blue">Blue</option>
                                <option value="Orange">Orange</option>
                                <option value="Gray">Gray</option>
                                <option value="Silver">Silver</option>
                                <option value="Golden">Golden</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="group_code">Group Code</label>
                            <input type="text" name="group_code" id="group_code" value="{{ old('group_code')}}"  class="form-control" placeholder="Enter Group Code">
                          </div>
                          <div class="form-group">
                            <label for="product_price">Product Price*</label>
                            <input type="text" value="{{ old('product_price')}}" name="product_price" id="product_price"  class="form-control" placeholder="Enter Product Price">
                          </div>
                          <div class="form-group">
                            <label for="product_discount">Product Discount (%)</label>
                            <input type="text" name="product_discount" id="product_discount"  class="form-control" value="{{ old('product_discount')}}" placeholder="Enter Product Discount (%)">
                          </div>
                          <div class="form-group">
                            <label for="product_weight">Product Weight</label>
                            <input type="text" value="{{ old('product_weight')}}" name="product_weight" id="product_weight"  class="form-control" placeholder="Enter Product Weight">
                          </div>
                          <div class="form-group">
                            <label for="product_image">product Video</label>
                            <input type="file" name="product_video" id="product_video" class="form-control">
                          </div>
                          <div class="form-group">
                            <label for="fabric">Fabric</label>
                            <select class="form-control" name="fabric">
                                <option value="">Select</option>
                                @foreach($productsFilters['fabricArray'] as $fabric)
                                  <option value="{{ $fabric }}">{{ $fabric }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="sleeve">Sleeve</label>
                            <select class="form-control" name="sleeve">
                                <option value="">Select</option>
                                @foreach($productsFilters['sleeveArray'] as $sleeve)
                                  <option value="{{ $sleeve }}">{{ $sleeve }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="pattern">Pattern</label>
                            <select class="form-control" name="pattern">
                                <option value="">Select</option>
                                @foreach($productsFilters['patternArray'] as $pattern)
                                  <option value="{{ $pattern }}">{{ $pattern }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="fit">Fit</label>
                            <select class="form-control" name="fit">
                                <option value="">Select</option>
                                @foreach($productsFilters['fitArray'] as $fit)
                                  <option value="{{ $fit }}">{{ $fit }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="occasion">Occasion</label>
                            <select class="form-control" name="occasion">
                                <option value="">Select</option>
                                @foreach($productsFilters['occasionArray'] as $occasion)
                                  <option value="{{ $occasion }}">{{ $occasion }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                              <label for="description">Description</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Product Description"></textarea>
                          </div>
                          <div class="form-group">
                              <label for="wash_care">Wash Care</label>
                              <textarea class="form-control" rows="3" id="wash_care" name="wash_care" placeholder="Enter Wash Care"></textarea>
                          </div>
                          <div class="form-group">
                              <label for="search_keywords">Search Keywords</label>
                              <textarea class="form-control" rows="3" id="search_keywords" name="search_keywords" placeholder="Enter Search Keywords"></textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Enter Meta Title">
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" class="form-control"  name="meta_description" id="meta_description"  placeholder="Enter Meta Description">
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Enter Meta Keywords">
                          </div>
                          <div class="form-group">
                              <label for="is_featured">Featured Item</label>
                              <input type="checkbox" name="is_featured" value="Yes">
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