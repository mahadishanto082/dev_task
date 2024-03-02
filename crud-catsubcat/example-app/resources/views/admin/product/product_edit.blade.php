@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product Edit</a></li>
    </ol>
  </nav>

  <div>
    <form action="{{route('product.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
       <div class="card">
        <div class="card-header"><h3>Edit product</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                  {{-- hidden id --}}
                  <input type="hidden" name="product_id" value="{{$product_info->id}}">



                    <div class="mb-3">
                        <label for="">Product name</label>
                        <input type="text" class="form-control" name="product_name" value="{{$product_info->product_name}}">
                    </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                      <label for="">Product Price</label>
                      <input type="number" class="form-control" name="product_price"
                      value="{{$product_info->product_price}}">
                  </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                    <label for="">Product Discount</label>
                    <input type="number" class="form-control" name="product_discount"value="{{$product_info->product_discount}}">
                </div>
            </div>
          
            <div class="col-lg-12">
              <div class="mb-3">
                  <label for="">Select Category</label>
                  <select name="category_id" id="category_id" class="form-control">
                    <option value="">-- Select --</option> 
                    @foreach ($categories as $cat )
                    <option {{$cat->id==$product_info->category_id?'selected':''}} value="{{$cat->id}}">{{$cat->category_name}}</option>                  
                    @endforeach                 
                  </div>
                  </select> 
              </div>
         

          <div class="col-lg-10">
            <div class="mb-3">
                <label for="">Select Subcategory</label>
                <select name="subcategory_id"n id="sub" class="form-control">
                  <option value="">-- Select --</option>   
                  @foreach ($subcategories as $scat )
                    <option {{$scat->id==$product_info->subcategory_id?'selected':''}} value="{{$scat->id}}">{{$scat->subcategory_name}}</option>                  
                    @endforeach               
                </select>
            </div>
        </div>

        <div class="col-lg-10">
          <div class="mb-3">
              <label for="">Product Brand</label>
              <select name="brand_id"n id="sub" class="form-control">
                <option value="">-- Select --</option>   
                @foreach ($brands as $b )
                  <option {{$b->id==$product_info->brand?'selected':''}}  value="{{$b->id}}">{{$b->brand_name}}</option>                  
                  @endforeach               
              </select>
          </div>
      </div>

      <div class="col-lg-8">
        <div class="mb-3">
            <label for="">Short Description</label>
            <input type="text" class="form-control" name="short_desp" value="{{$product_info->short_desp}}">
        </div>
    </div>

    <div class="col-lg-12">
      <div class="mb-3">
          <label for="">Long Description</label>
          {{-- <input type="text" class="form-control" name="long_desp"> --}}
          <textarea id="summernote" name="long_desp" value="{{$product_info->long_desp}}">{{$product_info->long_desp}}</textarea>
      </div>
  </div>

  <div class="col-lg-12">
    <div class="mb-3">
        <label for="">Additional Information</label>
        <textarea id="summernote2" name="additional_info">{{$product_info->additional_info}}</textarea>
    </div>
</div>

<div class="col-lg-6">
  <div class="mb-3">
      <label for="">Product Preview</label>
      <input type="file" class="form-control" name="preview">
      <div class="my-2">
        <img src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="">
      </div>
  </div>
</div>
<div class="col-lg-6">
  <div class="mb-3">
      <label for="">Product gallery</label>
      <input type="file" multiple class="form-control" name="preview">
      <div class="my-2">
        @foreach ($gallery_images as $gallary)
        <img width="200" src="{{asset('uploads/product/gallery')}}/{{$gallary->gallery}}" alt=""> 
        @endforeach
      </div>
  </div>
</div>
<div class="col-lg-6 mt-5 m-auto">
  <div class="mb-5 mt-5">
      <button type="submit" class="btn btn-primary form-control">Update product</button>
  </div>
</div>

  @endsection
  @section('footer_script')
<script>
  $(document).ready(function() {
      $('#summernote').summernote();
      $('#summernote2').summernote();
  });
</script>
@endsection