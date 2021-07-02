<?php

namespace App\Http\Controllers;

use App\Models\PatientState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PatientStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$patientstates = PatientState::all();
        //return $patientstates;
        return "PatientStateController@index()";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patientState = new PatientState();

        $patientState->patient_id = $request->input('userID');
        $patientState->date = $request->input('date');

        $patientState->weight = $request->input('weight');
        $patientState->IMC = $request->input('IMC');
        $patientState->muscle_mass = $request->input('musclemass');
        $patientState->fat_mass = $request->input('fatmass');
        $patientState->blood_pressure = $request->input('bloodpressure');
        $patientState->cholesterol = $request->input('cholesterol');

        //$patientState->checked = 1;

        $patientState->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientState  $patientState
     * @return \Illuminate\Http\Response
     */
    public function show($id)      // PatientState $patientState
    {
        // Con Query Builder
        /*
        $patientStates = DB::select('SELECT * FROM patient_states WHERE patient_id = ?', [$id]);
        return $patientStates;
        */

        // Con Eloquent ORM
        $patientStates = PatientState::where('patient_id', $id)->get();
        return $patientStates;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientState  $patientState
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientState $patientState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientState  $patientState
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $patient, $patientstatedate)         // PatientState $patientState
    {
        //$patientState = DB::select('SELECT * FROM patient_states WHERE patient_id = ? AND date = ?', [$patient, $patientstatedate]);
        // Lo que devuelve  DB::select()  no es una instancia de ningún modelo, Query Builder de Laravel no es Eloquent ORM donde los métodos estáticos de los modelos permiten consultar la BD e inicializar con los datos recuperados una instancia del modelo en cuestión.
        // https://laracasts.com/discuss/channels/eloquent/how-can-i-get-object-with-query-builder-in-laravel
        // Query builder solo devuelve un objeto o array de objetos como datos, no son instancias.
        // Con lo cual, no podemos acceder a ninguna propiedad de estos para asignarles los valores recibidos.
        // Para eso se debería crear una instancia e ir asignando los valores del objeto recibido? Pero tendría el mismo problema de no poder acceder a las propiedades del objeto?
        // $patientState = new PatientState();
        /*
        $patientState->weight = $request->input('weight');
        $patientState->IMC = $request->input('IMC');
        $patientState->muscle_mass = $request->input('musclemass');
        $patientState->fat_mass = $request->input('fatmass');
        $patientState->blood_pressure = $request->input('bloodpressure');
        $patientState->cholesterol = $request->input('cholesterol');

        $patientState->save();
        */

        //return $patientState;
        //return $request->input('weight');


        $affected = DB::table('patient_states')       // $affected:  The number of rows affected by the statement will be returned
            ->where([
                ['patient_id', '=', $patient],
                ['date', '=', $patientstatedate],
            ])
            ->update(
                [
                    'weight' => $request->input('weight'),
                    'IMC' => $request->input('IMC'),
                    'muscle_mass' => $request->input('musclemass'),
                    'fat_mass' => $request->input('fatmass'),
                    'blood_pressure' => $request->input('bloodpressure'),
                    'cholesterol' => $request->input('cholesterol'),
                ]);

        ///////////
        /*                          // <<---  No funciona usando Eloquent ORM
        $patientState = PatientState::where([
            ['patient_id', '=', $patient],
            ['date', '=', $patientstatedate],
        ])->first();
        $patientState->patient_id = $request->input('userID');
        $patientState->date = $request->input('date');
        $patientState->weight = $request->input('weight');
        $patientState->IMC = $request->input('IMC');
        $patientState->muscle_mass = $request->input('musclemass');
        $patientState->fat_mass = $request->input('fatmass');
        $patientState->blood_pressure = $request->input('bloodpressure');
        $patientState->cholesterol = $request->input('cholesterol');
        $patientState->save();
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientState  $patientState
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientState $patientState)
    {
        //
    }
}
