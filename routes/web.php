<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\XxxController;

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
    return view('welcome');
});


/*
Route::get('/xxx/{id}', function($id) {      // Send parameters to route
    return 'xxx '.$id;
});
*/

// Points to a Controller method
/*
Route::get('/xxx', 'App\Http\Controllers\XxxController@index' );
*/


// Points to a Controller method
//Route::get('/xxx/{id}', 'App\Http\Controllers\XxxController@index');    // Send parameters to route




// Añadimos el Middleware CORS al grupo de rutas que queremos que permitan el acceso al dominio establecido en el middleware.
/*
Route::group(['middleware' => ['mycors']], function () {
//Rutas que permitirán el acceso
    // Route that points to all Controller methods
    Route::resource('xxx', 'App\Http\Controllers\XxxController');       // Recuerda que  resource::  asigna automátcamente las subrutas a todos los métodos CRUD de este Controller, con lo cual, todas quedan afectadas por el middleware 'Cors'.
});
*/


//Route::resource('xxx', 'App\Http\Controllers\XxxController');       // Recuerda que  resource::  asigna automátcamente las subrutas a todos los métodos CRUD de este Controller
                                                                      // Si quiero volver a hacer peticiones a las rutas de web.php, debo cambiar la URI de la petición AJAX, eliminando 'api/'. 