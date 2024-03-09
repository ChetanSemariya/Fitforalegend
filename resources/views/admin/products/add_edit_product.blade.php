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
                                   <option @if(!empty(@old('category_id')) && $cat['id']== @old('category_id')) selected="" @elseif(!empty($product['category_id']) && $product['category_id'] == $cat['id']) selected="" @endif value="{{ $cat['id'] }}">{{ $cat['category_name'] }}</option>
                                   @if(!empty($cat['subcategories']))
                                     @foreach($cat['subcategories'] as $subcat)
                                        <option @if(!empty(@old('category_id')) && $subcat['id']== @old('category_id')) selected="" @elseif(!empty($product['category_id']) && $product['category_id'] == $subcat['id']) selected="" @endif  value="{{ $subcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subcat['category_name']}}</option>
                                        @if(!empty($subcat['subcategories']))
                                           @foreach($subcat['subcategories'] as $subsubcat)
                                              <option @if(!empty(@old('category_id')) && $subsubcat['id']== @old('category_id')) selected=""  @elseif(!empty($product['category_id']) && $product['category_id'] == $subsubcat['id']) selected="" @endif value="{{ $subsubcat['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo;{{ $subsubcat['category_name']}} </option>
                                           @endforeach
                                        @endif
                                     @endforeach
                                   @endif
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="product_name">Product Name*</label>
                            <input type="text" name="product_name" id="product_name"  class="form-control" placeholder="Enter Product Name"  value="{{ old('product_name', $product['product_name'])}}">
                          </div>
                          <div class="form-group">
                            <label for="product_code">Product Code*</label>
                            <input type="text" name="product_code" id="product_code"  class="form-control" value="{{ old('product_code', $product['product_code'])}}" placeholder="Enter Product Code">
                          </div>
                          <div class="form-group">
                            <label for="product_color">Product Color*</label>
                            <input type="text" name="product_color" id="product_color"  class="form-control" value="{{ old('product_color', $product['product_color'])}}" placeholder="Enter Product Color">
                          </div>
                          @php $familyColors = \App\Models\Color::colors() @endphp
                          <div class="form-group">
                            <label for="family_color">Family Color*</label>
                            <select class="form-control" name="family_color">
                                <option value="">Select</option>
                                @foreach($familyColors as $color)
                                   <option value="{{ $color['color_name']}}" @if(!empty(old('family_color')) && old('family_color') == $color['color_name']) selected="" @elseif(!empty($product['family_color']) && $product['family_color'] == $color['color_name']) selected="" @endif>{{ $color['color_name']}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="group_code">Group Code</label>
                            <input type="text" name="group_code" id="group_code" value="{{ old('group_code', $product['group_code'])}}"  class="form-control" placeholder="Enter Group Code">
                          </div>
                          <div class="form-group">
                            <label for="product_price">Product Price*</label>
                            <input type="text" value="{{ old('product_price', $product['product_price'])}}" name="product_price" id="product_price"  class="form-control" placeholder="Enter Product Price">
                          </div>
                          <div class="form-group">
                            <label for="product_discount">Product Discount (%)</label>
                            <input type="text" name="product_discount" id="product_discount"  class="form-control" value="{{ old('product_discount', $product['product_price'])}}" placeholder="Enter Product Discount (%)">
                          </div>
                          <div class="form-group">
                            <label for="product_weight">Product Weight</label>
                            <input type="text" value="{{ old('product_weight', $product['product_weight'])}}" name="product_weight" id="product_weight"  class="form-control" placeholder="Enter Product Weight">
                          </div>
                          <div class="form-group">
                            <label for="product_image">product Image's (Recommend Size: 1040 x 1200 )</label>
                            <input type="file" name="product_images[]" id="product_images" multiple="" class="form-control">
                            <table cellpadding="10" cellspacing="10" border="1" style="margin:10px;"><tr>
                            @foreach($product['images'] as $image)
                            <td style="background-color:#f9f9f9;">
                              <a target="_blank" href="{{ url('front/images/products/large/'.$image['image'])}}"><img src="{{ asset('front/images/products/small/'.$image['image'])}}" width="60px"></a>&nbsp;
                              <input type="hidden" name="image[]" value="{{ $image['image'] }}">
                              <input style="width:30px;" type="text" name="image_sort[]" value="{{ $image['image_sort']}}">
                              <a class="confirmDelete" href="javascript:void(0)" record="product-image" recordid="{{ $image['id'] }}" title="Delete product image"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>
                            </td>
                            @endforeach
                            </tr>
                            </table>
                          </div>
                          <div class="form-group">
                            <label for="product_image">product Video (Recommend Size: Less than 2 MB)</label>
                            <input type="file" name="product_video" id="product_video" class="form-control">
                            @if(!empty($product['product_video']))
                               <a target="_blank" href="{{ url('front/videos/products/'. $product['product_video'])}}">View Video</a>&nbsp;|
                               <a class="confirmDelete" href="javascript:void(0)" record="product-video" recordid="{{ $product['id'] }}" title="Delete Product Video"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="product_attributes">Added Attributes</label>
                            <table style="background-color: #52585e; width: 50%;" cellpadding="5" class="border border-striped">
                              <tr>
                                <th>ID</th>
                                <th>Size</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                              </tr>
                              @foreach($product['attributes'] as $attribute)
                              <input type="hidden" name="attributeId[]" value="{{ $attribute['id'] }}">
                              <tr>
                                <td>{{ $attribute['id'] }}</td>
                                <td>{{ $attribute['size'] }}</td>
                                <td>{{ $attribute['sku'] }}</td>
                                <td>
                                   <input type="number" style="width:100px;" name="price[]" value="{{ $attribute['price'] }}">
                                </td>
                                <td>
                                  <input type="number" style="width:100px;" name="stock[]" value="{{ $attribute['stock'] }}"> 
                                </td>
                                <td>
                                  @if($attribute['status'] ==1)
                                  <a class="updateAttributeStatus" id="attribute-{{ $attribute['id']}}" attribute_id="{{ $attribute['id'] }}" href="javascript:;void(0)" style='color:#3f6ed3'><i class="fas fa-toggle-on" status="Active"></i>
                                  </a>
                                  @else
                                  <a class="updateAttributeStatus" id="attribute-{{ $attribute['id']}}" attribute_id="{{ $attribute['id']}}" style="color:gray" href="javascript:;void(0)"><i class="fas fa-toggle-off" status="Inactive"></i>
                                  </a>
                                  @endif
                                  &nbsp;&nbsp;
                                  <a class="confirmDelete" href="javascript:void(0)" record="attribute" recordid="{{ $attribute['id'] }}" title="Delete attribute"><i class="fas fa-trash" style='color:#3f6ed3'></i></a>
                                </td>
                              </tr>
                              @endforeach
                            </table>
                          </div>
                          <div class="form-group">
                            <label for="product_attributes">Add Product Attributes</label>
                            <div class="field_wrapper">
                              <div>
                                  <input type="text" name="size[]" id="size" placeholder="Size"  style="width:120px;"/>
                                  <input type="text" name="sku[]" id="sku" placeholder="SKU"  style="width:120px;"/>
                                  <input type="text" name="price[]" id="price" placeholder="Price"  style="width:120px;"/>
                                  <input type="text" name="stock[]" id="stock" placeholder="Stock"  style="width:120px;"/>
                                  <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="fabric">Fabric</label>
                            <select class="form-control" name="fabric">
                                <option value="">Select</option>
                                @foreach($productsFilters['fabricArray'] as $fabric)
                                  <option value="{{ $fabric }}" @if(!empty(old('fabric')) && old('fabric') == $fabric) selected="" @elseif(!empty($product['fabric']) && $product['fabric'] == $fabric) selected="" @endif>{{ $fabric }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="sleeve">Sleeve</label>
                            <select class="form-control" name="sleeve">
                                <option value="">Select</option>
                                @foreach($productsFilters['sleeveArray'] as $sleeve)
                                  <option value="{{ $sleeve }}"  @if(!empty(old('sleeve')) && old('sleeve') == $sleeve) selected="" @elseif(!empty($product['sleeve']) && $product['sleeve'] == $sleeve) selected="" @endif>{{ $sleeve }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="pattern">Pattern</label>
                            <select class="form-control" name="pattern">
                                <option value="">Select</option>
                                @foreach($productsFilters['patternArray'] as $pattern)
                                  <option value="{{ $pattern }}" @if(!empty(old('pattern')) && old('pattern') == $pattern) selected="" @elseif(!empty($product['pattern']) && $product['pattern'] == $pattern) selected="" @endif>{{ $pattern }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="fit">Fit</label>
                            <select class="form-control" name="fit">
                                <option value="">Select</option>
                                @foreach($productsFilters['fitArray'] as $fit)
                                  <option value="{{ $fit }}" @if(!empty(old('fit')) && old('fit') == $fit) selected="" @elseif(!empty($product['fit']) && $product['fit'] == $fit) selected="" @endif>{{ $fit }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="occasion">Occasion</label>
                            <select class="form-control" name="occasion">
                                <option value="">Select</option>
                                @foreach($productsFilters['occasionArray'] as $occasion)
                                  <option value="{{ $occasion }}" @if(!empty(old('occasion')) && old('occasion') == $occasion) selected="" @elseif(!empty($product['occasion']) && $product['occasion'] == $occasion) selected="" @endif>{{ $occasion }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                              <label for="description">Description</label>
                              <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Product Description">{{ $product['description']}}</textarea>
                          </div>
                          <div class="form-group">
                              <label for="wash_care">Wash Care</label>
                              <textarea class="form-control" rows="3" id="wash_care" name="wash_care" placeholder="Enter Wash Care">{{  $product['wash_care']}}</textarea>
                          </div>
                          <div class="form-group">
                              <label for="search_keywords">Search Keywords</label>
                              <textarea class="form-control" rows="3" id="search_keywords" name="search_keywords" placeholder="Enter Search Keywords">{{ $product['search_keywords']}}</textarea>
                          </div>
                          <div class="form-group">
                              <label for="meta_title">Meta Title</label>
                              <input type="text" name="meta_title" value="{{ old('meta_title', $product['meta_title'])}}" id="meta_title" class="form-control" placeholder="Enter Meta Title">
                          </div>
                          <div class="form-group">
                              <label for="meta_description">Meta Description</label>
                              <input type="text" class="form-control" value="{{ old('meta_description', $product['meta_description'])}}"  name="meta_description" id="meta_description"  placeholder="Enter Meta Description">
                          </div>
                          <div class="form-group">
                              <label for="meta_keywords">Meta Keywords</label>
                              <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $product['meta_keywords'])}}" id="meta_keywords" class="form-control" placeholder="Enter Meta Keywords">
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