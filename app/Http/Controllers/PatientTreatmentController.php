<?php

namespace App\Http\Controllers;

use App\Models\PatientTreatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $patientTreatment = new PatientTreatment();

        $patientTreatment->patient_id = $request->input('patient_id');
        $patientTreatment->patient_state_date = $request->input('patient_state_date');
        $patientTreatment->treatment_date = $request->input('treatment_date');

        $patientTreatment->diet = $request->input('diet');
        $patientTreatment->medication = $request->input('medication');
        $patientTreatment->physical_activity = $request->input('physical_activity');
        $patientTreatment->observations = $request->input('observations');

        $patientTreatment->doctor = $request->input('doctor');

        $patientTreatment->save();

        // Cuando se asigna un tratamiento, hay que actualizar el campo checked de la tabla patient_status.
        $affected = DB::table('patient_states')       // $affected:  The number of rows affected by the statement will be returned
        ->where([
            ['patient_id', '=', $request->input('patient_id')],
            ['date', '=', $request->input('patient_state_date')],
        ])
            ->update(
                [
                    'checked' => true,
                ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientTreatment  $patientTreatment
     * @return \Illuminate\Http\Response
     */
    public function show($patient, $patientstatedate)        // PatientTreatment $patientTreatment
    {
        // Con Query Builder
        /*
        $patientTreatment = DB::select('SELECT * FROM patient_treatments WHERE patient_id = ? AND patient_state_date = ?', [$patient, $patientstatedate]);
        return $patientTreatment;
        */

        //return $patient." ".$patientstatedate;

        // Con Eloquent ORM
        $patientTreatment = PatientTreatment::where([
            ['patient_id', '=', $patient],
            ['patient_state_date', '=', $patientstatedate],
        ])->first();             // con ->first() retorna un solo objeto, con ->get() retornaría un objeto dentro de un array (porque podrian haber más coincidencias)

        if ($patientTreatment) {
            // Consulta combinada entre Patient_treatments y las tablas Diets, Medications y Physical_activities para recuperar el registro de cada una de estas al que apuntan las FK correspondientes de Patient_treatments
            $patientTreatment_Diet = DB::select('SELECT d.id AS diet_id, d.image AS diet_image, d.name AS diet_name, d.description AS diet_description FROM patient_treatments pt JOIN diets d ON pt.diet = d.id WHERE patient_id = ? AND patient_state_date = ?', [$patient, $patientstatedate]);
            $patientTreatment_Medication = DB::select('SELECT m.id AS medication_id, m.image AS medication_image, m.name AS medication_name, m.posology AS medication_posology FROM patient_treatments pt JOIN medications m ON pt.medication = m.id WHERE patient_id = ? AND patient_state_date = ?', [$patient, $patientstatedate]);
            $patientTreatment_PhysicalActivity = DB::select('SELECT pa.id AS physical_activities_id, pa.image AS physical_activities_image, pa.name AS physical_activities_name, pa.description AS physical_activities_description FROM patient_treatments pt JOIN physical_activities pa ON pt.physical_activity = pa.id WHERE patient_id = ? AND patient_state_date = ?', [$patient, $patientstatedate]);

            // Montamos los resultados de las tablas relacionadas con Patient_treatments en el objeto resultante de la consulta a Patient_treatments
            $patientTreatment->diet = $patientTreatment_Diet[0];    // La consulta que nos ha dado el valor de $patientTreatment_Diet no limita el resultado a un solo registro aunque solo haya una coincidencia, con lo cual, devolverá un array siempre aunque este contenga un solo objeto (objeto equivalente al registro coincidente).
            $patientTreatment->medication = $patientTreatment_Medication[0];
            $patientTreatment->physical_activity = $patientTreatment_PhysicalActivity[0];

            return $patientTreatment;
        } else {
            return $patientTreatment;
        }




    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientTreatment  $patientTreatment
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientTreatment $patientTreatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientTreatment  $patientTreatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $patient, $patientstatedate)     // PatientTreatment $patientTreatment
    {
        //return("Hola! petición recibida a PatientTreatment@update");
        // En este método update() creo que no es necesario  return. Si el status que recibe el frontend es 200, habrá ido bien.

        $affected = DB::table('patient_treatments')       // $affected:  The number of rows affected by the statement will be returned
        ->where([
            ['patient_id', '=', $patient],
            ['patient_state_date', '=', $patientstatedate],
        ])
            ->update(
                [
                    'diet' => $request->input('diet'),
                    'physical_activity' => $request->input('physical_activity'),
                    'medication' => $request->input('medication'),
                    'observations' => $request->input('observations'),
                ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientTreatment  $patientTreatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientTreatment $patientTreatment)
    {
        //
    }
}
