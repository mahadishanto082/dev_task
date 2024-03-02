@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Variation</a></li>
    </ol>
  </nav>

  <div class="row">

    <div class="col-lg-7">
        
        <div class="card">
            <div class="card-header">
                <h3>Color List</h3>
            </div>


            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        
                        <th>Color name</th>
                        <th>Color code</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $c )
                        
                    <tr>
                       
                        <td>{{$c->color_name}}</td>
                        <td>
                                <span class="badge" 
                                style="background
                                :{{$c->color_code}};">
                               {{$c->color_code}}
                                </span>
                        </td>
                         <td>
                            
                            <button type="button" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </button>
                          
                        </td>
                        
                    </tr>
                    @endforeach
                </table>
            </div>



        </div>


    </div>


    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h3>Add new color</h3>
            </div>

            <div class="card-body">
                <form action="{{route('variation.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Color name
                        </label>
                        <input type="text" name="color_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">
                            Color Code
                        </label>
                        <input type="text" name="color_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button name="btn" value="1" type="submit" class="btn btn-primary">Add color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{--/////////////////////////////////////////////////// size////////SIZEE///////////////////////////////////////////////////////z --}}
{{-- <div class="col-lg-7">
        
    <div class="card">
        <div class="card-header">
            <h3>Color List</h3>
        </div>


        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    
                    <th>Size name</th>
                    <th>Category name</th>
                    <th>Action</th>
                </tr>
                @foreach ($sizes as $s )
                    
                <tr>
                   
                    <td>{{$s->size_name}}</td>
                    <td>{{$s->category_id==null?'NA':$s->rel_to_category->category_name}}</td>
                     <td>
                        
                        <button type="button" class="btn btn-danger btn-icon">
                            <i data-feather="trash"></i>
                        </button>
                      
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>



    </div>


</div> --}}


<div class="col-lg-3">
    <div class="card mt-5">
        <div class="card-header">
            <h3>Add new size</h3>
        </div>

        <div class="card-body">
            <form action="{{route('variation.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">
                        Size name
                    </label>
                    <input type="text" name="size_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">
                       Category
                    </label>
                   <select name="size_category_id" class="form_control">
                    <option value="">--SELECT--</option>
                    @foreach ($categories as $c )
                        
                    <option value="{{$c->id}}">
                        {{$c->category_name}}
                    </option>
                    @endforeach
                   </select>
                </div>
                
                <div class="mb-3">
                    <button name="btn" value="2" type="submit" class="btn btn-primary">Add size</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{--/////////////////////////////////////////////////// size////////SIZEE///////////////////////////////////////////////////////z --}}


<div class="col-lg-7 mt-5">
        
    <div class="card">
        <div class="card-header">
            <h3>Size List</h3>
        </div>


        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Category</th>
                    <th>Size name</th>
                    <th>Action</th>
                </tr>
                @foreach ($sizes as $c )
                    
                <tr>
                   
                    <td>{{$c->category_id==null?'NA':$c->rel_to_category->category_name}}</td>
                    <td>{{$c->size_name}}</td>
                     <td>
                        <button type="button" class="btn btn-danger btn-icon">
                            <i data-feather="trash"></i>
                        </button>
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>



    </div>


</div>
  </div>

  
{{-- category wise size starts --}}
<div class="row mt-5 mx-2">
    @foreach ($categories as $cat )
        
   
    <div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h3>{{$cat->category_name}}</h3>
        </div>


        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                   
                    <th>Size name</th>
                    <th>Action</th>
                </tr>
                @foreach (App\Models\Size::where('category_id',$cat->id)->get() as $c )
                    
                <tr>
                   
                    {{-- <td>{{$c->category_id==null?'NA':$c->rel_to_category->category_name}}</td> --}}
                    <td>{{$c->size_name}}</td>
                     <td>
                        <button type="button" class="btn btn-danger btn-icon">
                            <i data-feather="trash"></i>
                        </button>
                    </td>
                    
                </tr>
                @endforeach
            </table>
        </div>



    </div>
</div>
@endforeach
</div>
{{-- category wise size  ends--}}
@endsection