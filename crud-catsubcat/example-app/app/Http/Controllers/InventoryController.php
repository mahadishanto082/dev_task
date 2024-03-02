<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class InventoryController extends Controller
{
    function variation(){
        $colors = color::all();
        $sizes = Size::all();
        $categories =Category::all();
        //$sizes = 
        return view('admin.product.variation',[
            'colors'=>$colors,
            'sizes'=>$sizes,
            'categories'=>$categories,
        ]);
    }

    function variation_store(Request $request){

       // echo $request->btn;
       if($request->btn==1){
       color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
             'created_at'=>Carbon::now(),
        ]);
        return back();
       }
       else{
        Size::insert([
            'size_name'=>$request->size_name,
            'category_id'=>$request->size_category_id,
            'created_at'=>Carbon::now(),
        ]);
        return back();
       }

       
    }
   //inventory
   function product_inventory($product_id){
    $colors = color::all();
    $product_info = Product::find($product_id);
    //first() = 1 row  or will return only one record
    $sizes = Size::where('category_id',$product_info->category_id)->get();
    // return $sizes;
    // die();
    $inventory =  Inventory::where('product_id',$product_id)->get();
    return view('admin.product.inventory',[
        'colors'=>$colors,
        'sizes'=>$sizes,
        'product_info'=>$product_info,
        'inventory'=>$inventory,
    ]);
   }
    
   function inventory_store(Request $request){

    if(Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->exists()){


        Inventory::where('product_id',$request->product_id)->where('color_id',$request->color_id)->where('size_id',$request->size_id)->increment('quantity',$request->quantity);
        return back();

    }else{
        Inventory::insert([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>Carbon::now(),
        ]);
    }


   
    return back();
   }
}
