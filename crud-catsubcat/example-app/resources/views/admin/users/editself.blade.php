@extends('layouts.dashboard')
@section('content')
{{-- 
<div class="row" > --}}
<div class="row">
    {{-- //For Name and email update --}}

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Edit Yout Profile Information</h6>
             								
                <form class="forms-sample" method="POST" action="{{route('update.profile.info')}}">
                    @csrf
                    <div class="form-group">
                        <label for="colFormLabelSm">Name</label>
                        <input type="text" class="form-control form-control-sm" id="colFormLabelSm" name="name" value="{{Auth::user()->name}}">
                    </div>

                    <div class="form-group">
                        <label for="colFormLabel">Email</label>
                        <input type="email" name="email" class="form-control" id="colFormLabel" value="{{Auth::user()->email}}">
                    </div>

                    {{-- <div class="form-group mb-0">
                        <label for="colFormLabelLg" class="pb-0">Password</label>
                        <input type="email" class="form-control form-control-lg" id="colFormLabelLg" placeholder="Password" name="password">
                    </div> --}}


                    <br>
                    <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
                </form>
            </div>
            </div>
    </div>

    {{-- For password update --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update Password</h6>
                
                
                @if (session('success'))
                <div class="alert alert-success">
                    <strong class="text-success">{{session('success')}}</strong> 
                </div>
                
                @endif
             								
                <form class="forms-sample" method="POST" action="{{route('update.password')}}">
                    @csrf
                    <div class="form-group">
                        <label for="colFormLabelSm"> Old Password</label>
                        <input type="password" class="form-control " id="colFormLabelSm" name="old_password" >
                        @error('old_password')
                           <strong class="text-danger">{{$message}}</strong> 
                        @enderror
                        {{-- show session msgs --}}
                        @if (session('old_wrong'))
                        <strong class="text-danger">{{session('old_wrong')}}</strong> 
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="colFormLabelSm"> New Password</label>
                        <input type="password" class="form-control" id="colFormLabelSm" name="password" >
                        @error('password')
                           <strong class="text-danger">{{$message}}</strong> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="colFormLabelSm"> Confirm Password</label>
                        <input type="password" class="form-control" id="colFormLabelSm" name="password_confirmation" >
                        @error('password_confirmation')
                           <strong class="text-danger">{{$message}}</strong> 
                        @enderror
                    </div>




                    <br>
                    <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
                </form>
            </div>
            </div>
    </div>


    {{-- for photo update --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Edit profile photo</h6>
                
                
                @if (session('successp'))
                <div class="alert alert-success">
                    <strong class="text-success">{{session('successp')}}</strong> 
                </div>
                
                @endif
             								
                <form class="forms-sample" method="POST" action="{{route('update.photo')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="colFormLabelSm">Upload profile photo</label>
                        <input type="file" class="form-control " id="colFormLabelSm" name="photo"   onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                        
                        
                        @error('photo')
                           <strong class="text-danger">{{$message}}</strong> 
                        @enderror

                       
                    </div>

                    <div class="my-2">
                        <img src="" width="200px" id="blah" alt="">
                    </div>
                   
                  
                    <br>
                    <button type="submit" class="btn btn-primary mr-2">Update photo</button>
                </form>
            </div>
            </div>
    </div>
</div>
    {{-- </div> --}}
@endsection