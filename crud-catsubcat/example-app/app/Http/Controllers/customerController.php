<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Customerlogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class customerController extends Controller
{
    function customer_reg_log(){
        return view('frontend.customer.register_login');
    }


    //register customer
    function customer_register_store(Request $request){
        //print_r($request->all());
        Customerlogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'created_at'=>Carbon::now(),
        ]);


        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/indexhome');

       // return back();
    }
}




    function customer_login(Request $request){
       // echo 'hello';
        if(Auth::guard('customerlogin')->attempt(['email'=>$request->email,'password'=>$request->password])){
            //echo 'all ok';
            //validation has to be done
            return redirect('/indexhome');
        }else{
            //echo 'not ok';
            return back()->with('wrong','wrong credential');
        }
    }



    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect('/indexhome');
    }


    //profile
    function customer_profile(){
        return view('frontend.customer.profile');
    }




    //profile update
    function customer_profile_update(Request $request ){


       if($request->photo == ''){
        if($request->password==''){
            //photo & password null

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                    ]);
                    return back();
        }else{

            //photo null but  password not null
            if(Hash::check($request->old_password,Auth::guard('customerlogin')->user()->password)){

                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'password'=>Hash::make($request->password),
                ]); 
                return back();  
            }else{
                return back()->with('old','Current Password Is Wrong');
            }
           
        }

       }else{
        //if photo exists
        //photo not null
        
        if($request->password==''){

            //photo starts 
            $photo = $request->photo;
            $extension = $photo->getClientOriginalExtension();
            $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
            // photo ends
           

                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'photo'=>$file_name,
                    ]);
                    return back();
        }else{

            //photo null but  password not null
            if(Hash::check($request->old_password,Auth::guard('customerlogin')->user()->password)){
                //photo starts 
            $photo = $request->photo;
            $extension = $photo->getClientOriginalExtension();
            $file_name = Auth::guard('customerlogin')->id().'.'.$extension;
            Image::make($photo)->save(public_path('uploads/customer/'.$file_name));
            // photo ends

                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'password'=>Hash::make($request->password),
                    'photo'=>$file_name,
                    
                ]); 
                return back();  
            }else{
                return back()->with('old','Current Password Is Wrong');
            }
        }

       }
    }



    
}

