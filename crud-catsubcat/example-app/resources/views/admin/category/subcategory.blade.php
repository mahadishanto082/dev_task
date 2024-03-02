@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Subcategory List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Subcategory</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($subcategories as $sl=>$sub)
                        
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$sub->subcategory_name}}</td>
                        
                       
                       <td>
                         {{$sub->rel_to_category->category_name}}

                        
                            {{-- {{$sub->rel_to_category->category_id==null?'not assigned':$sub->rel_to_category->category_name}}
                             --}}
                       </td>


                           {{-- <td>
                            {{$sub->category_id==null?'not assigned':$sub->rel_to_category->category_name}}
                            </td> --}}
                              
                           
                     

                       

                        <td><img width="100" src="{{asset('uploads/subcategory')}}/{{$sub->subcategory_image}}" alt=""></td>
                        <td><a href="{{route('sub.delete',$sub->id)}}" class="btn btn-danger">Delete</a></td>
                        <td><a href="{{route('subcategory.edit',$sub->id)}}" class="btn btn-info">Edit</a></td>
                    </tr>
                    @empty
                   <tr>
                    <td colspan="5" class="text-center">Empty</td>
                   </tr>
                    @endforelse
                </table>
            </div>
            </div>
            <br>
         
        </div>
 
         {{-- add sub  --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Subcategory</h3>
            </div>
            <div class="card-body">
                <form action="{{route('subcategory.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <select name="category_id" class="form-control">
                            <option value="">--Select Category</option>
                            @foreach ($categories as $cate)    
                            <option value="{{$cate->id}}">{{$cate->category_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Sub Category Image</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" placeholder="subCategory Image" name="subcategory_image">
                        
                    </div>

                    <div class="mb-3">
                       <button type="submit" class="btn btn-primary">Add subcategory</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
        {{-- end sub --}}

        {{-- trash starts --}}
        <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
               
               {{-- trash category --}}
               <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Subcategory</th>
                        {{-- <th>Category</th> --}}
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trash_subcategories as $sl=>$sub)
                        
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$sub->subcategory_name}}</td>
                        {{-- <td>{{$sub->rel_to_category->category_name}}</td> --}}

                        {{-- <td>
                            {{$sub->category_id==''?'not assigned':$sub->rel_to_category->category_name}}</td> --}}



                        <td><img width="100" src="{{asset('uploads/subcategory')}}/{{$sub->subcategory_image}}" alt=""></td>
                        <td><a href="{{route('sub.perdelete',$sub->id)}}" class="btn btn-danger">Delete</a></td>
                        <td><a href="{{route('subcategory.edit',$sub->id)}}" class="btn btn-info">Edit</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
             
        </div>


    </div>
</div>
{{-- trash category ends --}}

   
</div>
<div class="row my-5">
    @foreach ($categories as $c )
        <div class="col-lg-6 mt-5">
            <div class="card">
                <div class="card-header">
                    <h5>{{$c->category_name}}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-dark">
                        <tr>
                           <th>Subcategory name</th>
                           <th>Subcategory Image</th>
                           <th>Action</th>
                        </tr>
                       
                        @foreach (App\Models\Subcategory::where('category_id',$c->id)->get() as $s )
                        <tr>
                            <td>{{$s->subcategory_name}}</td>
                            <td><img src="{{asset('uploads/subcategory/')}}/{{$s->subcategory_image}}" alt=""></td>
                            <td><a href="{{route('sub.perdelete',$sub->id)}}" class="btn btn-danger">Delete</a>
                                <a href="{{route('subcategory.edit',$sub->id)}}" class="btn btn-info">Edit</a>
                            </td>
                            
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @endforeach
            </div>

@endsection