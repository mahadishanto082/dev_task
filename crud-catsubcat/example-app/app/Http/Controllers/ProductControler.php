<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;


class ProductControler extends Controller
{
    function add_product(){
        $brands =Brand::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.add_product',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
        ]);
    }

    function getSubcategory(Request $request){
       // echo $request->category_id;
       // can ech it in success: of ajax 
       $sub = Subcategory::where('category_id',$request->category_id)->get();
      // print_r($sub);
     // echo $sub;
     $str = '<option value="">-- Select --</option> ';
     foreach($sub as $s){
        $str .= '<option value="'.$s->id.'">'.$s->subcategory_name.'</option> ';
     }
     echo $str;
    }


    function product_store(Request $request){
        $dis=($request->product_price*$request->product_discount)/100;
       $after_dis =$request->product_price-$dis;
    //    echo $after_dis;
    //     die();
    //sku
 
   $random_number = random_int(10000,99999);
   $random_number2 = random_int(100000,999999);

   $sku=Str::Upper(str_replace(' ','-',substr($request->product_name,0,2))).'-'.$random_number;
//  echo $sku;
//  die();
   $slug = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number2;

        $product_id= Product::insertGetId([
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'product_discount'=>$request->product_discount,
            'product_after_discount'=>$after_dis,
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'brand'=>$request->brand,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'additional_info'=>$request->additional_info,
            'sku'=>$sku,
            'slug'=>$slug,
            'created_at'=>Carbon::now(),

        ]);

        // product image preview
        $preview_image =$request->preview;
        if($preview_image!=''){

                $extension = $preview_image->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number2.'.'.$extension;

                //saves image a package has been used
                Image::make($preview_image)->save(public_path('uploads/product/preview/'.$file_name));

                Product::find($product_id)->update([
                    'preview'=>$file_name,
                ]);
        }
        







        //product gallery images will save in a different table 
        $gallery_images = $request->gallery;

        if($gallery_images!=''){
            //print_r($gallery_images);
        foreach($gallery_images as $sl=> $gallery){
            //echo $gallery;
            $extension_gallery = $gallery->getClientOriginalExtension();
           // echo $extension_gallery.'<br>';
           $file_name_gallery = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number.'.'.$sl.'.'.$extension_gallery;

           Image::make($gallery)->save(public_path('uploads/product/gallery/'.$file_name_gallery));

           ProductGallery::insert([
              'product_id'=>$product_id,
              'gallery'=>$file_name_gallery,
              'created_at'=>Carbon::now(),
           ]);
        }

        }
        


 return back();
    }

    //product list 
    function product_list(){
        $all_product=Product::all();
        return view('admin.product.product_list',[
            'all_products'=>$all_product,
        ]);
    }

    // product view or edit
    function product_edit(Request $request){
       
        $product_info = Product::find($request->pro_id);
        $gallery_images = ProductGallery::where('product_id',$request->pro_id)->get();
        // print_r($gallery_images) ;
        // die();
        // echo $request->pro_id;
        // die();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
         return view('admin.product.product_edit',[
            'product_info'=>$product_info,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
           'gallery_images'=>$gallery_images,
         ]);
    }

    //product update
    function product_update(Request $request){
        $random_number = random_int(10000,99999);

        if($request->preview ==''){
            if($request->gallery == ''){
                //dont have preview or gallery
                //will update others except gallery and preview
                Product::find($request->product_id)->update(
                    [
                       
                        'product_name'=>$request->product_name,
                        'product_price'=>$request->product_price,
                        'product_discount'=>$request->product_discount,
                        'product_after_discount'=>$request->product_price-(($request->product_price*$request->product_discount)/100),
        
                        'category_id'=>$request->category_id,
                        'subcategory_id'=>$request->subcategory_id,
                        'brand'=>$request->brand,
                        'short_desp'=>$request->short_desp,
                        'long_desp'=>$request->long_desp,
                        'additional_info'=>$request->additional_info,
                        'created_at'=>Carbon::now(),
                    ]
                );

            }else{
                //No preview , but have gallery
                //update others with gallery except preview

                //remove previous gallery image
                $present_gallery = ProductGallery::where('product_id',$request->product_id)->get();
                foreach($present_gallery as $g){
                    $delete_from = public_path('uploads/product/gallery/'.$g->gallery);
                    unlink($delete_from);
                     ProductGallery::where('product_id',$g->product_id)->delete();
                }
                //remove previous gallery image
                
                $gallery_images = $request->gallery;
                  foreach($gallery_images as $sl=> $gallery){
                    $extension_gallery = $gallery->getClientOriginalExtension();
                 $file_name_gallery = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number.'.'.$sl.'.'.$extension_gallery;
    
               Image::make($gallery)->save(public_path('uploads/product/gallery/'.$file_name_gallery));
    
               ProductGallery::insert([
                'product_id'=>$request->product_id,
                'gallery'=>$file_name_gallery,
                 'created_at'=>Carbon::now(),
               ]);
            }

            }
        }else{
            //have preview
            if($request->gallery == ''){
                //dont have gallery,but have a preview


                            
                            //delete previous preview image
                            $prev_image = Product::find($request->product_id);
                            $delete_from = public_path('uploads/product/preview/'.$prev_image->preview);
                            unlink($delete_from);
                            //delete previous preview image
                            $preview_image =$request->preview;
                      
                            $random_number2 = random_int(100000,999999);
                            $extension = $preview_image->getClientOriginalExtension();
                            $file_name = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number2.'.'.$extension;

                            //saves image a package has been used
                            Image::make($preview_image)->save(public_path('uploads/product/preview/'.$file_name));

                            // Product::find($request->product_id)->update([
                            //     'preview'=>$file_name,
                            // ]);
                            Product::find($request->product_id)->update(
                                [
                                   
                                    'product_name'=>$request->product_name,
                                    'product_price'=>$request->product_price,
                                    'product_discount'=>$request->product_discount,
                                    'product_after_discount'=>$request->product_price-(($request->product_price*$request->product_discount)/100),
                    
                                    'category_id'=>$request->category_id,
                                    'subcategory_id'=>$request->subcategory_id,
                                    'brand'=>$request->brand,
                                    'short_desp'=>$request->short_desp,
                                    'long_desp'=>$request->long_desp,
                                    'additional_info'=>$request->additional_info,
                                    //preview update
                                    'preview'=>$file_name,
                                    'created_at'=>Carbon::now(),
                                ]
                            );

                    

            }else{
                //Have gallery and preview
                ////////////preview
                //delete previous preview image
                $prev_image = Product::find($request->product_id);
                $delete_from = public_path('uploads/product/preview/'.$prev_image->preview);
                unlink($delete_from);
                //delete previous preview image
                $preview_image =$request->preview;
          
                $random_number2 = random_int(100000,999999);
                $extension = $preview_image->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number2.'.'.$extension;

                //saves image a package has been used
                Image::make($preview_image)->save(public_path('uploads/product/preview/'.$file_name));










                ////////////////gallery

                   //remove previous gallery image
                $present_gallery = ProductGallery::where('product_id',$request->product_id)->get();
                foreach($present_gallery as $g){
                    $delete_from = public_path('uploads/product/gallery/'.$g->gallery);
                    unlink($delete_from);
                     ProductGallery::where('product_id',$g->product_id)->delete();
                }
                //remove previous gallery image
                
                $gallery_images = $request->gallery;
                  foreach($gallery_images as $sl=> $gallery){
                    $extension_gallery = $gallery->getClientOriginalExtension();
                 $file_name_gallery = Str::lower(str_replace(' ','-',substr($request->product_name,0,3))).'-'.$random_number.'.'.$sl.'.'.$extension_gallery;
    
               Image::make($gallery)->save(public_path('uploads/product/gallery/'.$file_name_gallery));
    
               ProductGallery::insert([
                'product_id'=>$request->product_id,
                'gallery'=>$file_name_gallery,
                 'created_at'=>Carbon::now(),
               ]);
            }








                Product::find($request->product_id)->update(
                    [
                       
                        'product_name'=>$request->product_name,
                        'product_price'=>$request->product_price,
                        'product_discount'=>$request->product_discount,
                        'product_after_discount'=>$request->product_price-(($request->product_price*$request->product_discount)/100),
        
                        'category_id'=>$request->category_id,
                        'subcategory_id'=>$request->subcategory_id,
                        'brand'=>$request->brand,
                        'short_desp'=>$request->short_desp,
                        'long_desp'=>$request->long_desp,
                        'additional_info'=>$request->additional_info,
                        //preview update
                        'preview'=>$file_name,
                        'created_at'=>Carbon::now(),
                    ]
                );

            }
            
        }


return back();

        
    }




    
//product delete
function product_delete($product_id){
Product::find($product_id)->delete();
return back();
}

}
