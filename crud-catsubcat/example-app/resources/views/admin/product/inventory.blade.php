@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Inventory</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8"> 
      <div class="card">
        <div class="card-header">
            <h3>Inventory List</h3>
        </div>
       
            <table class="table table-bordered">
                <tr>
                  
                    <th>Color</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                @foreach ($inventory as $i )
                    
                <tr>
                    <td>{{$i->rel_to_color->color_name}}</td>
                    <td>{{$i->size_id==null?'NA':$i->rel_to_size->size_name}}</td>
                    <td>{{$i->quantity}}</td>
                 
                    
                     
                    <td> <a href="" class="btn btn-danger">DELETE</a></td>

                       
                    
                </tr>
                @endforeach
            </table>
  
    </div>
    </div>


    {{-- form --}}
    <div class="col-lg-4">
        <form action="{{route('inventory.store')}}" method="POST">
            @csrf
         <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="" class="form-label">
                       Product name
                    </label>
                    <input type="text" readonly value="{{$product_info->product_name}}"  class="form-control">
                    <input type="hidden" name="product_id" value="{{$product_info->id}}">

                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                       Color
                     </label>
                     <select  id="" name="color_id" class="form-control">
                        <option value="">Select one</option>
                        @foreach ($colors as $c) 
                        <option value="{{$c->id}}">{{$c->color_name}}</option>
                        @endforeach
                     </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                      Size
                     </label>
                     <select id="" name="size_id" class="form-control">
                        <option value="">Select one</option>
                        @foreach ($sizes as $c) 
                        <option value="{{$c->id}}">{{$c->size_name}}</option>
                        @endforeach
                     </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                      Quantity
                    </label>
                    <input type="number" name="quantity" class="form-control">
                </div>
                <div class="mb-3">
                    <button name="btn" value="1" type="submit" class="btn btn-primary">Add inventory</button>
                </div>
            </div>
         </div>
        </form>
    </div>
  </div>
@endsection