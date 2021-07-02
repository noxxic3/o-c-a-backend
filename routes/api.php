<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



// Mostrar las rutas existentes:   php artisan route:list

Route::resource('xxx', 'App\Http\Controllers\XxxController');

// Las RUTAS van en plural...
Route::get('news', 'App\Http\Controllers\NewsController@index');

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::delete('logout/{id}', 'App\Http\Controllers\AuthController@logout');


Route::middleware(['auth:sanctum'])->group(function () {     // The routes that require authentication go within the Auth middleware group

    //Route::apiResource('users', 'App\Http\Controllers\UserController');       // <<-- Route Model Binding funciona sin   ->middleware('api')
    //Route::get('users', 'App\Http\Controllers\UserController@index');
    Route::get('users', 'App\Http\Controllers\UserController@show');
    Route::post('users', 'App\Http\Controllers\UserController@store');
    Route::put('users/{id}/{role}', 'App\Http\Controllers\UserController@update');
    Route::delete('users/{id}/{role}', 'App\Http\Controllers\UserController@destroy');

    //Route::apiResource('roles', 'App\Http\Controllers\RoleController');

    //Route::apiResource('patients', 'App\Http\Controllers\PatientController');
    //Route::get('patients/{name}/{surname}/{to_check}', 'App\Http\Controllers\PatientController@show');
    Route::get('patients', 'App\Http\Controllers\PatientController@show');

    /*// Bind the 'users' key to the given closure                      // Route Model Bindings
    Route::bind('patientstate', function (string $keys) {
        return 'Users FTW!';
    });*/

    //Route::apiResource('patientstates', 'App\Http\Controllers\PatientStateController');
    Route::get('patientstates/{patient}', 'App\Http\Controllers\PatientStateController@show');
    Route::post('patientstates', 'App\Http\Controllers\PatientStateController@store');
    Route::put('patientstates/{patient}/{patientstatedate}', 'App\Http\Controllers\PatientStateController@update');

    //Route::apiResource('patienttreatments', 'App\Http\Controllers\PatientTreatmentController');
    Route::get('patienttreatments/{patient}/{patientstatedate}', 'App\Http\Controllers\PatientTreatmentController@show');
    Route::put('patienttreatments/{patient}/{patientstatedate}', 'App\Http\Controllers\PatientTreatmentController@update');
    Route::post('patienttreatments', 'App\Http\Controllers\PatientTreatmentController@store');




    //Route::apiResource('diets', 'App\Http\Controllers\DietController');
    Route::get('diets', 'App\Http\Controllers\DietController@index');
    Route::post('diets', 'App\Http\Controllers\DietController@store');
    Route::put('diets/{id}', 'App\Http\Controllers\DietController@update');
    Route::delete('diets/{id}', 'App\Http\Controllers\DietController@destroy');

    //Route::apiResource('medications', 'App\Http\Controllers\MedicationController');
    Route::get('medications', 'App\Http\Controllers\MedicationController@index');
    Route::post('medications', 'App\Http\Controllers\MedicationController@store');
    Route::put('medications/{id}', 'App\Http\Controllers\MedicationController@update');
    Route::delete('medications/{id}', 'App\Http\Controllers\MedicationController@destroy');

    //Route::apiResource('physicalactivities', 'App\Http\Controllers\PhysicalActivityController');
    Route::get('physicalactivities', 'App\Http\Controllers\PhysicalActivityController@index');
    Route::post('physicalactivities', 'App\Http\Controllers\PhysicalActivityController@store');
    Route::put('physicalactivities/{id}', 'App\Http\Controllers\PhysicalActivityController@update');
    Route::delete('physicalactivities/{id}', 'App\Http\Controllers\PhysicalActivityController@destroy');
});


