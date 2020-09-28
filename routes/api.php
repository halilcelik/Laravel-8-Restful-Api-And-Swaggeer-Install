<?php
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 Route::middleware('auth:api')->get('/user', function (Request $request) {
     return $request->user();
 });
 Route::middleware('auth.basic')->get('/user-basic', function (Request $request) {
     return $request->user();
 });

// Route::get('/hello', function(){
//     return "Hello Restful Api";
// });
// Route::get('/users', function(){

//   return \App\Models\User::factory()->count(10)->make();

// });
/* DİKKAT!!!  Bu aşağıdaki iki satır route'lar az olunca tercih edilir
 eğer router'lar çoksa diğer yöntem tercih edilir.   */

/* Route::apiResource('products', ProductController::class);
   Route::apiResource('users', UserController::class); 
   Route::apiResource('categories', CategoryController::class); */

Route::get('categories/custom1', [CategoryController::class, 'custom1']);
Route::get('products/custom1', [ProductController::class, 'custom1']);
Route::get('products/custom2', [ProductController::class, 'custom2']);
Route::get('categories/report1', [CategoryController::class, 'report1']);
Route::get('users/custom1', [UserController::class, 'custom1']);
Route::get('products/custom3', [ProductController::class, 'custom3']);
Route::get('products/listwithcategories', [ProductController::class, 'listWithCategories']);

Route::middleware('auth:api', 'throttle:rate_limit,1')->group(function(){
    Route::apiResources([
    'products'=> ProductController::class,
    'users' => UserController::class,
    'categories' => CategoryController::class

]);
});
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('upload', [UploadController::class, 'upload']);

Route::middleware('api-token')->group(function(){
    Route::get('/auth/token', function (Request $request) {
        $user = $request->user();
       
        return response()->json([
            'name' => $user->name,
            'access_token' => $user->api_token,
            'time' => time()
        ]);
    });


});