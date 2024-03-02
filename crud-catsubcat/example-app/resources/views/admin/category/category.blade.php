@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Category</a></li>
    </ol>
  </nav>

    <div class="row">
        <div class="col-lg-8 ">
            <div class="card">
                <div class="card-header">
                  
                    <h3> Category List</h3>
                    
                </div>
               
                <div class="card-body">
                    {{-- session starts --}}
                    <div>
                        @if (session('delete_success'))
                        <div class="alert alert-success">
                             {{session('delete_success')}}
                        </div>
                     @endif
                    </div>
                    {{-- session ends --}}

                    <form action="{{route('check.delete')}}" method="POST">
                        @csrf
                    
                  <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" id="chkAllcategory" >Check all</th>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $sl=>$categories )
                            
                        <tr>
                            <td><input class="category" type="checkbox" name="cat[]" value="{{$categories->id}}"></td>
                            <td>{{$sl+1}}</td>
                            <td>{{$categories->category_name}}</td>
                            
                            <td>
                              
								<img  width="70" src="{{asset('uploads/category')}}/{{$categories->category_image}}" > 
								
                            </td>
                           
                            
                            <td>
                             
                                <div class="dropdown mb-2">


                                    <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>


                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                      <a class="dropdown-item d-flex align-items-center" href="{{route('edit.category',$categories->id)}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                      
                                      <a class="dropdown-item d-flex align-items-center" href="{{route('category.delete',$categories->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>

                                    </div>
                                  </div>
                                </div>
                               
                            </td>
                        </tr>
                        @endforeach
                    </table>
               

                  <div class="my-3">
                    <button type="submit"  class="btn btn-outline-danger d-none show">DELETE</button>
                  </div>
                </form>  
                </div>
            </div>




            @if ($trash_categories->count()>=1)
                
           
            {{-- ////////////////// --}}
            
            <div class="card">
                <div class="card-header">
                  
                    <h3>Trash Category Lists &nbsp<span class="text-danger">{{$t}}</span></h3>
                    
                </div>
               
                <div class="card-body">
                    {{-- session starts --}}
                    <div>
                        @if (session('pdelete_success'))
                        <div class="alert alert-success">
                             {{session('pdelete_success')}}
                        </div>
                     @endif
                    </div>

                    {{-- session ends --}}
                    {{-- {{route('c.delete')}} --}}
                    <form action="{{route('trashcheck.delete')}}" method="POST">
                        @csrf
                  <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" id="cid" >Check all</th>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trash_categories as $s=>$cat )
                            
                        <tr>
                            <td><input class="ca" type="checkbox" name="cat[]" value="{{$cat->id}}"></td>
                            <td>{{$s+1}}</td>
                            <td>{{$cat->category_name}}</td>
                            
                            <td>
                              
								<img  width="70" src="{{asset('uploads/category')}}/{{$cat->category_image}}" > 
								
                            </td>
                           
                            
                            <td>
                             
                                <div class="dropdown mb-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                      <a class="dropdown-item d-flex align-items-center" href="{{route('restore.category',$cat->id)}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Restore</span></a>
                                      <a class="dropdown-item d-flex align-items-center" href="{{route('category.Pdel',$cat->id)}}"><i data-feather="trash" class="icon-sm mr-2"></i><span class="">Delete permanently</span></a>

                                    </div>
                                  </div>
                                </div>
                               
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="my-3">
                        <button type="submit"  class="btn btn-outline-danger d-none t">DELETE</button>
                      </div>
                </form>
                </div>
            </div>
            {{-- ////////////////// --}}
            @endif
        </div>

        

    <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
                <h6 class="card-title">Add new category</h6>

                <form class="forms-sample" enctype="multipart/form-data" action="{{route('category.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Category Name</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Category Name" name="category_name">
                        @error('category_name')
                            <strong class="text-danger">'{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category Image</label>
                        <input type="file" class="form-control" id="exampleInputEmail1" placeholder="Category Image" name="category_image">
                        @error('category_image')
                        <strong class="text-danger">'{{$message}}</strong>
                    @enderror
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    
                </form>
</div>
</div>
    </div>
    
    
    </div>

    
@endsection
@section('footer_script')
<script>
    $("#chkAllcategory").on('click', function(){
    $('.show').toggleClass('d-none');
     this.checked ? $(".category").prop("checked",true) : $(".category").prop("checked",false);  
})
$(".category").on('click', function(){
    $('.show').toggleClass('d-none');
})


// trashcategory all check
$("#cid").on('click', function(){
    $('.t').toggleClass('d-none');
     this.checked ? $(".ca").prop("checked",true) : $(".ca").prop("checked",false);  
})
$(".ca").on('click', function(){
    $('.t').toggleClass('d-none');
})
</script>
@endsection