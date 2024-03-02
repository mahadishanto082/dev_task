@extends('layouts.dashboard')

@section('content')
{{-- <div class="container">
    <div class="roe">
        <div class="col-lg-12 m-auto"> --}}
            <div class="col-md-12 m-auto">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Edit information</h6>

                                @if ($errors->any())
                                   <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                        <form class="forms-sample" method="POST" action="{{route('user.update',$user->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="exampleInputUsername2" name="name" value="{{$user->name}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="exampleInputEmail2" autocomplete="off"  name="email" value="{{$user->email}}">
                                </div>
        
                            </div>
                             
                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                           
                        </form>
                    </div>
                </div>
            </div>
        
        {{-- </div>
    </div>
</div> --}}
@endsection