@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Product list</a></li>
    </ol>
  </nav>
{{-- table to show products --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($all_products as $pro )
                        
                    <tr>
                        <td>{{$pro->product_name}}</td>
                        <td>{{$pro->product_price}} &#2547</td>
                        <td>{{$pro->product_discount==null?'0%':$pro->product_discount}} %</td>
                        <td>{{$pro->product_after_discount}} &#2547</td>
                        <td>
                            <img src="{{asset('uploads/product/preview')}}/{{$pro->preview}}" alt="">

                        </td>
                        <td>
                            <a href="{{route('product.inventory',$pro->id)}}" class="btn btn-info btn-icon">
                                <i style="color:wheat" data-feather="layers"></i>
                            </a>
                            <button type="button" class="btn btn-primary btn-icon">
                                <i data-feather="eye"></i>
                            </button>



                            {{-- <a href="{{route('product_edit',$pro->id)}}" class="btn btn-info btn-icon" style="color: white">
                                <i data-feather="edit"></i>
                            </a> --}}

                            {{-- form --}}
                            <form action="{{route('product.edit')}}" class="d-inline" method="GET" >
                                @csrf
                                <button name="pro_id" value="{{$pro->id}}" class="btn btn-info btn-icon" style="color: white">
                                    <i data-feather="edit"></i>

                                </button>
                            </form>
                            {{-- form end --}}




                            <a href="{{route('product.delete',$pro->id)}}" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </a>
                            {{-- <a href="" class="btn btn-danger">DELETE</a>
                            <a href="" class="btn btn-info">Edit</a> --}}

                            
                        </td>
                        
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection