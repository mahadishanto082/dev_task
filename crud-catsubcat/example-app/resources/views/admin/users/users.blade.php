@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="roe">
        <div class="col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                    {{-- <h3>User List -{{$var}}</h3> --}}
                    <h3>User List <span class="float-right">Total: {{$total_user-1}}</span></h3>
                    {{-- <h3>User List <span class="float-end">Total: {{$total_user}}</span></h3> --}}
                </div>
               
                


                <div class="card-body">
                    {{-- session starts --}}
                    <div>
                        @if (session('success'))
                        <div class="alert alert-success">
                             {{session('success')}}
                        </div>
                     @endif
                    </div>
                    {{-- session ends --}}


                  <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($users as $sl=>$user )
                            
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->photo==null)
								<img src="{{ Avatar::create($user->name)->toBase64() }}" />
								@else
								<img src="{{asset('uploads/user_profile_image')}}/{{$user->photo}}" alt="profile"> 
								@endif
                            </td>
                            {{-- <td>{{$user->created_at->format('d-m-y h:i:s')}}</td> --}}
                            <td>{{$user->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('user.edit',$user->id)}}" class="btn btn-primary">EDIT</a>

                                {{-- <a href="{{route('user.delete',$user->id)}}" class="btn btn-danger">DELETE</a> --}}
                                <form action="{{route('user.delete',$user->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">DELETE</button> 
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection