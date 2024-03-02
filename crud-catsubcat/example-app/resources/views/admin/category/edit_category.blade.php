@extends('layouts.dashboard')
@section('content')
{{-- breadcrumbs starts --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Edit Category</a></li>
    </ol>
  </nav>
{{-- breadcrumbs ends --}}
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
        <div class="card-header">Edit Category</div>
        <div class="card-body">

            <form class="forms-sample" enctype="multipart/form-data" action="{{route('category.update')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputUsername1">Category Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="category_name" value="{{$category_info->category_name}}">
                    {{-- @error('category_name')
                        <strong class="text-danger">'{{$message}}</strong>
                    @enderror --}}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Category Image</label>
                    <input type="file" class="form-control" id="exampleInputEmail1" placeholder="Category Image" name="category_image"  value="{{$category_info->category_image}}" onchange="document.getElementById('bbb').src = window.URL.createObjectURL(this.files[0])">
                    
                    @error('category_image')
                    <strong class="text-danger">'{{$message}}</strong>
                @enderror
                </div>
                <div class="my-2">
                    <img width="100" src="{{asset('uploads/category')}}/{{$category_info->category_image}}" width="200px" id="bbb" alt="">
                </div>
                <input type="hidden" name="category_id" value="{{$category_info->id}}">
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                
            </form>
        </div>
    </div>
</div>
</div>



@endsection