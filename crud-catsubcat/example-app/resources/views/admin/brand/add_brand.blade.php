@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Brand</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
                    <h6 class="card-title">Add new Brand</h6>
    
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('brand.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Brand Name</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="brand Name" name="brand_name">
                            @error('brand_name')
                                <strong class="text-danger">'{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Brand Logo</label>
                            <input type="file" class="form-control" id="exampleInputEmail1" placeholder="Brand Logo" name="brand_logo">
                            @error('brand_logo')
                            <strong class="text-danger">'{{$message}}</strong>
                        @enderror
                        </div>
                        
                        
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        
                    </form>
    </div>
    </div>
        </div>


        {{-- table for listing --}}
        <div class="col-lg-8 ">
            <div class="card">
                        <div class="card-header">
                            <h3> Brand List</h3>
                        </div>
               
                <div class="card-body">


                    {{-- session starts --}}
                    {{-- <div>
                        @if (session('delete_success'))
                        <div class="alert alert-success">
                             {{session('delete_success')}}
                        </div>
                     @endif
                    </div> --}}
                    {{-- session ends --}}


                  <table class="table table-bordered">
                        <tr>
                           
                            <th>SL</th>
                            <th>Brand Name</th>
                            <th>Brand Logo</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $brands as $sl=>$brand )
                            
                        <tr>
                            {{-- ctrl+p for searching --}}
                            {{--Class  27 --}}
                            <td>{{$sl+1}}</td>
                            <td>{{$brand->brand_name}}</td>
                            
                            <td>
                                @if ($brand->brand_logo!=null)
                                <img src="{{asset('uploads/brand')}}/{{$brand->brand_logo}}"> 
                                  
                                @else
                                <img src="{{ Avatar::create($brand->brand_name)->toBase64() }}" />
                                @endif
                    
                            </td>

                            <td>
                                <a href="#" class="btn btn-danger">DELETE</a>  
                                <a href="#" class="btn btn-info">Edit</a>  
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$brands->links()}}
               
                </div>
                  
             
                </div>
            </div>

  </div>


@endsection