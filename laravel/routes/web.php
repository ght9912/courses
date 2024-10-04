<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $s =Settings::where("pagina","=","home")->first();
    //return $s;
    return view('index',["setting"=>$s]);
})->name('index');;

Route::get('/about', function () {
    $s =Settings::where("pagina","=","about")->first();
    return view('about',["setting"=>$s]);
})->name('about');
Route::get('/post/{id}/{titulo}', [PostController::class, 'showPost'])->name('post.view');
Route::get('/post', [PostController::class, 'postList'])->name('post');;
Route::get('/contact', function () {
    $s =Settings::where("pagina","=","contact")->first();
    return view('contact',["setting"=>$s]);
})->name('contact');;

Route::post("/contact",[ContactFormController::class, "store"]);
Auth::routes();

//comentarios rutas
Route::post('/comment', [CommentsController::class, 'createFromPost']);;

Route::prefix('dashboard')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::resource("post",PostController::class);
        Route::post("post/uploadImage",[PostController::class,'uploadImage']);

        Route::resource("comments",CommentsController::class);
        Route::resource("users",UserController::class);
        Route::resource("settings",SettingsController::class);
        Route::resource("contact",ContactFormController::class);

    })->middleware('auth');
});
