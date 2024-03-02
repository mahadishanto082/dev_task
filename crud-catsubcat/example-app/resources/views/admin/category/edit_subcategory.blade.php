@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">SubCategory Edit</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-6 m-auto" >
        <div class="card">
            <div class="card-header">
                <h3>Edit Subcategory</h3>
            </div>
            <div class="card-body">
                <form action="{{route('subcategory.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" value="{{$subcategory_info->subcategory_name}}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $cate)  
                            <option  {{$cate->id==$subcategory_info->category_id?'selected':''}} value="{{$cate->id}}">{{$cate->category_name}}</option >


                                {{-- {{$category->id}}=={{$subcategory_info->id}} --}}

                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sub Category Image</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" placeholder="subCategory Image" name="subcategory_image" onchange="document.getElementById('bg').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    <div class="my-2">
                        <img src="{{asset('uploads/subcategory/')}}/{{$subcategory_info->subcategory_image}}" width="200px" id="bg" alt="">
                    </div>
                    <input type="hidden" name="subcategory_id" value="{{$subcategory_info->id}}">
                    <div class="mb-3">
                       <button type="submit" class="btn btn-primary">Update subcategory</button>
                    </div>
    
                </form>
            </div>
        </div>
    </div>
  </div>
@endsection