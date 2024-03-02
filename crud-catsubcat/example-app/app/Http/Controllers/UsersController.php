<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserPassUpdate;
use Illuminate\Validation\Rules\Password;
// use Image;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
 
    function users(){
        $users= User::where('id','!=', Auth::id())->get();
        $total_user = User::count();
        return view('admin.users.users',compact('users','total_user'));
    }
    function user_delete($user_id){
      // echo $user_id;
      User::find($user_id)->delete();
      return back()->with('success','User Deleted!');
    }



   //have to check model binding
    public function edit(User $user){
      //$user = User::find($id);
      return view('admin.users.edit',compact('user'));
    }

    

    public function update(Request $request ,$id){
      $user = User::find($id);
      $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|string|email|unique:users,email,'.$user->id,
      ],[
        'email.required'=>'Required email',
        'email.string'=>'Has to be a String',
        'email.email'=>'Has to be a real email',
        'email.unique'=>'Email has to be unique',
      ]);

      $user->update([
        "name"=> $request->name,
        "email"=> $request->email,
      ]);
      return redirect()->route('users')->with('success',"User info updated!!");
    }


    function user_selfedit(){
       return view('admin.users.editself');
    }

    function user_profile_update(Request $request){
      //print_r($request->all());
      //echo $request->name;
      //echo $request->email;
      //return User::find(Auth::id())
      User::find(Auth::id())->update([
        'name'=>$request->name,
        'email'=>$request->email,
      ]);
      return back();
    }

    function user_password_update(UserPassUpdate $request){
    // echo "adaada";
    if(Hash::check($request->old_password,Auth::user()->password)){
      //echo 'ok';'
      User::find(Auth::id())->update(
        [
          'password'=>bcrypt($request->password),
        ]
        );
        return back()->with('success','Password updated');

    }else{
      //echo 'not ok';
      return back()->with('old_wrong','Password did not match');
    }

    }
    //photo update function
    function user_photo_update(Request $request){
      //print_r($request->photo);
      //$upload_photo =$request->photo;

      //valiadate image
      // $request->validate([
      //   'photo'=>'required',
      //   'photo'=>'image',
      // ]);

      $request->validate([
        'photo'=>['required', 'mimes:jpg,png,webp',],
        'photo'=>'file|max:512',
      ]);
      $prev_photo=public_path('uploads/user_profile_image/'.Auth::user()->photo);
      unlink($prev_photo);

      $upload_photo =$request->photo;
      $extension = $upload_photo->getClientOriginalExtension();
     // echo $extension;
     $file_name = Auth::id().  '.'  .$extension;
      //echo $file_name;
      Image::make($upload_photo)->save(public_path('uploads/user_profile_image/'.$file_name));

      User::find(Auth::id())->update(
        [
            'photo'=>$file_name,
        ]
        );

      return back()->with('successp','Photo uploaded successfully');
    }

}
