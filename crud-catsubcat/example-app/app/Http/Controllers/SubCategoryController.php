<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SubCategoryController extends Controller
{
    function subcategory(){
        
        $categories =Category::all();
        $subcategories =SubCategory::all();
        $trash_subcategories = SubCategory::onlyTrashed()->get();
        return view('admin.category.subcategory',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
             'trash_subcategories'=>$trash_subcategories,
        ]);
    }


    function subcategory_store(Request $request){

        if($request->subcategory_image==''){
            Subcategory::insert([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
            ]);
            return back();
        }else{
        $random_number = random_int(100000,999999);
        $subcategory_image=$request->subcategory_image;
        $extension = $subcategory_image->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ','-',$request->subcategory_name)).'-'.$random_number.'.'.$extension;
        Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));
        //insert
        Subcategory::insert([
            'subcategory_name'=>$request->subcategory_name,
            'category_id'=>$request->category_id,
            'subcategory_image'=>$file_name,
        ]);
        }

       
        return back();
    }
    //normal delete
    function sub_delete($subcategory_id){
       // echo $subcategory_id;
       SubCategory::find($subcategory_id)->delete();
        return back();
    }
    //permanent delete
    function sub_perdelete($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->forceDelete();
        return back()->with('D','Yeap deleted!');
    }
    //restore
    function sub_restore($subcategory_id){
        Subcategory::onlyTrashed()->find($subcategory_id)->restore();
        return back();
    }
    

    //subcategory edit
    function subcategory_edit($subcategory_id){
        $categories =Category::all();
        $subcategory_info = Subcategory::find($subcategory_id);
        return view('admin..category.edit_subcategory',[
            'subcategory_info' =>$subcategory_info,
            'categories'=>$categories,
        ]);
    }

    //subcategory update
    function subcategory_update(Request $request){
        if($request->subcategory_image==''){
            Subcategory::find($request->subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
            ]);
            return back();
        }else{
            
           
            //for deleting previous image
                $subcat_image=Subcategory::find($request->subcategory_id);
                if($subcat_image->subcategory_image !=null){
                    $delete_from = public_path('uploads/subcategory/'.$subcat_image->subcategory_image);
                    unlink($delete_from);
                }
               

            //image validate
            $random_number = random_int(100000,999999);
            $subcategory_image=$request->subcategory_image;
            $extension = $subcategory_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ','-',$request->subcategory_name)).'-'.$random_number.'.'.$extension;
            Image::make($subcategory_image)->save(public_path('uploads/subcategory/'.$file_name));

            //update
            Subcategory::find($request->subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
                'subcategory_image'=>$file_name,
            ]);  
            return back();
        }
    }

}
