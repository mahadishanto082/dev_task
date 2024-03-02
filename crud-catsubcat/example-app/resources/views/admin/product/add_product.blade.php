@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Add products</a></li>
    </ol>
  </nav>
  {{-- form --}}
  <div>
    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
       <div class="card">
        <div class="card-header"><h3>Add new product</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="">Product name</label>
                        <input type="text" class="form-control" name="product_name">
                    </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-3">
                      <label for="">Product Price</label>
                      <input type="number" class="form-control" name="product_price">
                  </div>
              </div>
              <div class="col-lg-4">
                <div class="mb-3">
                    <label for="">Product Discount</label>
                    <input type="number" class="form-control" name="product_discount">
                </div>
            </div>
          
            <div class="col-lg-12">
              <div class="mb-3">
                  <label for="">Select Category</label>
                  <select name="category_id" id="category_id" class="form-control">
                    <option value="">-- Select --</option> 
                    @foreach ($categories as $cat )
                    <option value="{{$cat->id}}">{{$cat->category_name}}</option>                  
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
                    <option value="{{$scat->id}}">{{$scat->subcategory_name}}</option>                  
                    @endforeach               
                </select>
            </div>
        </div>

        <div class="col-lg-10">
          <div class="mb-3">
              <label for="">Product Brand</label>
              <select name="brand" class="form-control">
                <option value="">-- Select --</option>   
                @foreach ($brands as $b )
                  <option value="{{$b->id}}">{{$b->brand_name}}</option>                  
                  @endforeach               
              </select>
          </div>
      </div>

      <div class="col-lg-8">
        <div class="mb-3">
            <label for="">Short Description</label>
            <input type="text" class="form-control" name="short_desp">
        </div>
    </div>

    <div class="col-lg-12">
      <div class="mb-3">
          <label for="">Long Description</label>
          {{-- <input type="text" class="form-control" name="long_desp"> --}}
          <textarea id="summernote" name="long_desp"></textarea>
      </div>
  </div>

  <div class="col-lg-12">
    <div class="mb-3">
        <label for="">Additional Information</label>
        <textarea id="summernote2" name="additional_info"></textarea>
    </div>
</div>

<div class="col-lg-6">
  <div class="mb-3">
      <label for="">Product Preview</label>
      <input type="file" class="form-control" name="preview">
  </div>
</div>
<div class="col-lg-6">
  <div class="mb-3">
      <label for="">Product Gallery</label>
      <input type="file" multiple class="form-control" name="gallery[]">
  </div>
</div>

<div class="col-lg-6 mt-5 m-auto">
  <div class="mb-5 mt-5">
      <button type="submit" class="btn btn-primary form-control">Add product</button>
  </div>
</div>



              </div>
        </div>
       </div>

    </form>
  </div>
@endsection

@section('footer_script')
<script>
  $(document).ready(function() {
      $('#summernote').summernote();
      $('#summernote2').summernote();
  });
</script>

{{-- ajax --}}
<script>
  $('#category_id').change(function(){
    var category_id = $(this).val();
   // alert(category_id);
   $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
           });

           $.ajax({
            type:'POST',
            url:'/getSubcategory',
            data:{'category_id':category_id},
            success:function(data){
              //$.('#subcategory_id').html(data);
              //alert(data);
              $('#sub').html(data);
            }
           });

  })
 
</script>
@endsection