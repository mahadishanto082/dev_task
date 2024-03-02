@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Coupon</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon list</h3>
            </div>
            <div class="card-body">
                <table class="table table-border">
                    <tr>
                        <th>Coupon Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Expire Date</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $c)
                    <tr>
                        <td>{{$c->coupon_name}}</td>
                        <td>{{$c->type==1?'Percentage':'Fixed'}}</td>
                        <td>{{$c->amount}}</td>
                        {{-- <td>{{$c->expire_date}}</td> --}}
                        <td>
             {{  Carbon\Carbon::now()->diffInDays($c->expire_date , false );}}days left
                        </td>


                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    </div>


    <div class="col-lg-4">
        <div class="card-header">
            <h3>Add New Coupon</h3>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{route('coupon.store')}}" method="POST" >
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="coupon_name" class="form-control" placeholder="Coupon Name">
                    </div>
                    
                    <div class="mb-3">
                       <select name="type" class="form-control" id="">
                        <option value="">--Select type--</option>
                        <option value="1">Perentage</option>
                        <option value="2">Fixed</option>
                       </select>
                    </div> 
                    <div class="mb-3">
                        <input type="text" name="amount" class="form-control" placeholder="Amount">
                    </div> 
                    <div class="mb-3">
                        <input type="date" name="expire_date" class="form-control" placeholder="expire_date">
                    </div> 
                    <div class="mb-3">
                      <button type="submit" class="btn btn-primary">
                        Add coupon
                      </button>
                    </div> 
                    
                </form>
            </div>
        </div>
       
    </div>


  </div>
@endsection