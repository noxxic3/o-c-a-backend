<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Support\Facades\Route;    // C:\wamp64\www\8_TFG\ObesityControlApp\vendor\laravel\framework\src\Illuminate\Support\Facades

class PatientState extends Model
{
    use HasFactory;

    public $timestamps = false;

    /*
     public static function boot()
    {
        Route::bind('patientstate', function ($value) {       // Route Model Bindings: bind a parameter (patientstate) to a model (App\Models\PatientState)
            $patientstates = App\Models\PatientState::where('patient_id', $value)->get();
            return $patientstates;
            return "Patient states parameter";
        });
    }
    */
}
