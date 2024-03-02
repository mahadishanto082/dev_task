<?php

namespace App\Http\Controllers;



use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class categoryController extends Controller
{
    function category(){
        $categories = Category::all();
        $trash_categories = Category::onlyTrashed()->get();
        $t=$trash_categories->count();
        return view('admin.category.category',[
            'categories'=>$categories,
            'trash_categories'=>$trash_categories,
            't'=>$t,
        ]);
    }

    function category_store(Request $request){
        //print_r($request->all());
        //validation
        $request->validate([
            'category_name'=>'required|unique:categories',
            //'category_image'=>'required',
            'category_image'=>'image',
        ]);


        if($request->category_image==null){
         //insert
          Category::insert([
            'category_name'=>$request->category_name,
        ]);
        }else{
           $random_number = random_int(100000,999999);
           $category_image=$request->category_image;
           $extension = $category_image->getClientOriginalExtension();
           //makes name in lowercase
          // $file_name = Str::lower($request->category_name);
           $file_name = Str::lower(str_replace(' ','-',$request->category_name)).'-'.$random_number.'.'.$extension;
           //echo $file_name; 
          // echo $random_number; 
          Image::make($category_image)->save(public_path('uploads/category/'.$file_name));

          Category::insert([
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
        ]);

        }

      
        return back();
    }
//Normal delete
    function category_delete($category_id){
        //echo $category_id;

        Subcategory::where('category_id',$category_id)->delete();//problems with relation
        Category::find($category_id)->delete();
        return back()->with('delete_success','Category deleted successfully');
    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit_category',[
            'category_info'=>$category_info,
        ]);
    }

    function category_update(Request $request){
      if($request->category_image==''){
        Category::find($request->category_id)->update( [
            'category_name'=>$request->category_name,
           
    ]); return back();
      }else{

        $cat_image=Category::find($request->category_id);
        if($cat_image->category_image !=''){
            $delete_from = public_path('uploads/category/'.$cat_image->category_image);
            unlink($delete_from);
          
    
        }
       

        // $present_image = Category::find($request->category_id);
        // $delete_from = public_path('uploads/category/'.$present_image->category_image);
        // unlink($delete_from);

        $random_number = random_int(100000,999999);
        $category_image=$request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ','-',$request->category_name)).'-'.$random_number.'.'.$extension;
        Image::make($category_image)->save(public_path('uploads/category/'.$file_name));

        Category::find($request->category_id)->update( [
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
    ]);
      }
      return back();
    }

//Restore
    function restore_category($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }

//force delete
    function category_Pdel($category_id){

        // $sub =Subcategory::onlyTrashed()->where('category_id',$category_id)->forceDelete();
    //    echo $sub->subcategory_image;
    //    die();
        // if($sub->subcategory_image!=null){
        //     $delete_from = public_path('uploads/subcategory/'.$sub->subcategory_image);
        //     unlink($delete_from);  
        //     Subcategory::onlyTrashed()->find($category_id)->forceDelete();
        // }

        Subcategory::onlyTrashed()->where('category_id',$category_id)->forceDelete();


        // previous image delete 
        $cat_image=Category::onlyTrashed()->find($category_id);
        if($cat_image->category_image !=null){
            $delete_from = public_path('uploads/category/'.$cat_image->category_image);
            unlink($delete_from);


            //information of category
            Category::onlyTrashed()->find($category_id)->forceDelete();
            return back()->with('pdelete_success','Category deleted permanently!!!');
            


  ////////////////////////////////////////////////////////////////////////////////////          
        //    Subcategory::onlyTrashed()->find($sub->id)->forceDelete();
        //if category is deleted subcategory will also be deleted
        //  $S = Subcategory::where('category_id',$category_id)->get();
        //  foreach($S as $sub){
        //     //img delete
        //     $present_image = Subcategory::find($sub->id);
        //     $delete_from = public_path('uploads/subcategory/'.$present_image->subcategory_image);
        //     unlink($delete_from);
        //     //info delete
        //     Subcategory::find($sub->id)->delete(); 
            
        // }
        // $Subcategories = SubCategory::onlyTrashed()->where('category_id',$category_id)->get();
        
        // foreach($Subcategories as $sub){
        //     //img delete
        //     $present_image = Subcategory::find($sub->id);
        //     $delete_from = public_path('uploads/subcategory/'.$present_image->subcategory_image);
        //     unlink($delete_from);
        //     //info delete
        //    // Subcategory::find($sub->id)->delete(); 
        //     Subcategory::onlyTrashed()->find($sub->id)->forceDelete();
        // }//foreach



/////////////////////////////////////



          
        }//if
        else{
            Subcategory::onlyTrashed()->where('category_id',$category_id)->forceDelete();

            Category::onlyTrashed()->find($category_id)->forceDelete();
            return back()->with('pdelete_success','Category deleted permanently!!!');;
        }

        // $present_image = Category::onlyTrashed()->find($category_id);
        // $delete_from = public_path('uploads/category/'.$present_image->category_image);
        // unlink($delete_from);

       

//fo delete

/////////////////////////////////////
///force delete
        // Category::onlyTrashed()->find($category_id)->forceDelete();
        // return back()->with('pdelete_success','Category deleted permanently!!!');;
    }


    //check all delete
    function check_delete(Request $request){
        //print_r($request->cat);
        foreach($request->cat as $cc){
            Category::find($cc)->delete();
            
        }return back();
    }


  function trashcheck_delete(Request $request){
    //cat is the name="cat"value
        //print_r($request->cat);
        foreach($request->cat as $c){
            Category::onlyTrashed()->find($c)->forceDelete();
        }return back();
  }


}
