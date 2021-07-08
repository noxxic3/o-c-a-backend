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
        // With Query Builder
        /*
        $patientStates = DB::select('SELECT * FROM patient_states WHERE patient_id = ?', [$id]);
        return $patientStates;
        */

        // With Eloquent ORM
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

        // Query multiple id with Query Builder
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

        // Incorrect use of Query Builder with Raw SQL
        /*
        $patientState = DB::select('SELECT * FROM patient_states WHERE patient_id = ? AND date = ?', [$patient, $patientstatedate]);
        return $patientState;
        // What DB::select() returns is not an instance of any model, Laravel's Query Builder is not Eloquent ORM where the static methods of the models allow to query the DB and initialize with the retrieved data an instance of the model in question.
        // https://laracasts.com/discuss/channels/eloquent/how-can-i-get-object-with-query-builder-in-laravel
        // DB::select() only returns an object or array of objects as data, they are not instances. With which, we cannot access any property of these to assign the received values to them.

        // It is not correct to create a new instance and assign the values of the received object because it could not access the properties of the instance because they do not exist yet.
        $patientState = new PatientState();
        $patientState->weight = $request->input('weight');
        $patientState->IMC = $request->input('IMC');
        $patientState->muscle_mass = $request->input('musclemass');
        $patientState->fat_mass = $request->input('fatmass');
        $patientState->blood_pressure = $request->input('bloodpressure');
        $patientState->cholesterol = $request->input('cholesterol');
        $patientState->save();
        */


        // Doesn't work using Eloquent ORM
        /*
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
