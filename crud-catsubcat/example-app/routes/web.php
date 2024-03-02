<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\customerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductControler;
use App\Http\Controllers\SubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/about', function(){
// return view('about');
// });

// Route::get('/catto',function(){
//     return view('cat');
// });

// Route::get('/h',function(){
// return view('practise.hell');
// });




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/contact',[FrontendController::class,'contact']);

//users
  Route::get('/users',[UsersController::class,'users'])->name('users');


// user delete
//Route::get('/user/delete/{user_id}',[UsersController::class,'user_delete'])->name('user.delete');

//    Route::delete('/user/delete/{user_id}',[UsersController::class,'user_delete'])->name('user.delete');


// user Edit
//   Route::get('/user/edit/{id}',[UsersController::class,'edit'])->name('user.edit');



//user update
//   Route::put('/user/update/{id}',[UsersController::class,'update'])->name('user.update');

//route writing in short form
Route::controller(UsersController::class)->prefix('user')->name('user.')->group(function(){
    Route::delete('/delete/{user_id}','user_delete')->name('delete');
   // Route::get('/edit/{id}','edit')->name('edit');
    Route::get('/edit/{user}','edit')->name('edit');
    Route::put('/update/{id}','update')->name('update');
});

//user  self edit
Route::get('/user/selfedit',[UsersController::class,'user_selfedit'])->name('user.selfedit');
//user profile update route 
Route::post('/user/profile/update',[UsersController::class,'user_profile_update'])->name('update.profile.info');
//user self password updatte
Route::post('user/password/update',[UsersController::class,'user_password_update'])->name('update.password');
//route for photo
Route::post('/user/photo/update',[UsersController::class,'user_photo_update'])->name('update.photo');


//category route
Route::get('/category',[categoryController::class,'category'])->name('category');
Route::post('/category/store',[categoryController::class,'category_store'])->name('category.store');
//normal delete
Route::get('/category/delete{category_id}',[categoryController::class,'category_delete'])->name('category.delete');

Route::get('/category/edit{category_id}',[categoryController::class,'category_edit'])->name('edit.category');

Route::post('/category/update',[categoryController::class,'category_update'])->name('category.update');
Route::get('/category/restore{category_id}',[categoryController::class,'restore_category'])->name('restore.category');

Route::get('/category/permanent/delete/{category_id}',[categoryController::class,'category_Pdel'])->name('category.Pdel');

//delete all checked items
Route::post('/category/check/delete',[categoryController::class,'check_delete'])->name('check.delete');
//trash checked delete
Route::post('/trashcategory/check/delete',[categoryController::class,'trashcheck_delete'])->name('trashcheck.delete');

//subcategory
Route::get('/subcategory',[SubCategoryController::class,'subcategory'])->name('subcategory');
Route::post('/subcategory/store',[SubCategoryController::class,'subcategory_store'])->name('subcategory.store');

Route::get('/subcategory/normal/delete{subcategory_id}',[SubCategoryController::class,'sub_delete'])->name('sub.delete');
//permanent deletel dub

Route::get('/subcategory/permanent/delete{subcategory_id}',[SubCategoryController::class,'sub_perdelete'])->name('sub.perdelete');
//sub restore 
Route::get('/subcategory/restore{subcategory_id}',[SubCategoryController::class,'sub_restore'])->name('sub.restore');

//sub category edit 
Route::get('/subcategory/edit{subcategory_id}',[SubCategoryController::class,'subcategory_edit'])->name('subcategory.edit');
//sub cat update
Route::post('/subcategory/update',[SubCategoryController::class,'subcategory_update'])->name('subcategory.update');

//Products
//add product
Route::get('/add/product',[ProductControler::class,'add_product'])->name('product');
Route::get('/product/list',[ProductControler::class,'product_list'])->name('product.list');
Route::get('/product/edit',[ProductControler::class,'product_edit'])->name('product.edit');
Route::post('/product/update',[ProductControler::class,'product_update'])->name('product.update');
//delete product
Route::get('/product/delete/{product_id}',[ProductControler::class,'product_delete'])->name('product.delete');

    

//ajax route product
Route::post('/getSubcategory',[ProductControler::class,'getSubcategory']);
//product insert route
Route::post('/product/store',[ProductControler::class,'product_store'])->name('product.store');





//Variation
Route::get('/variation',[InventoryController::class,'variation'])->name('variation');
Route::post('/variation/store',[InventoryController::class,'variation_store'])->name('variation.store');

//Inventory
Route::get('product/inventory/{product_id}',[InventoryController::class,'product_inventory'])->name('product.inventory');
Route::post('product/inventory/store',[InventoryController::class,'inventory_store'])->name('inventory.store');

 

 

 
 //customer
 Route::get('/customer/register/login',[customerController::class,'customer_reg_log'])->name('customer.register.login');
 Route::post('/customer/register/store',[customerController::class,'customer_register_store'])->name('customer.register.store');
 Route::post('/customer/login',[customerController::class,'customer_login'])->name('customer.login');
 Route::get('/customer/logout',[customerController::class,'customer_logout'])->name('customer.logout');
 Route::get('/customer/profile',[customerController::class,'customer_profile'])->name('customer.profile');
 Route::post('/customer/profile/update',[customerController::class,'customer_profile_update'])->name('customer.profile.update');

 