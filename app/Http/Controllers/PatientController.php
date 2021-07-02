<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)           // $name, $surname, $checked   // Patient $patient
    {
        //return($request->name);
        //return($request);

        // Search for name
        if (!$request->surname && !$request->checked) {
            //return('solo name');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email
                                          FROM users u JOIN patients p ON u.id = p.user_id

                                          WHERE u.name = ?
                                          GROUP BY u.id', [$request->name]);
            return $patients;
        }

        // Search for surname
        if (!$request->name && !$request->checked) {
            //return('solo surname');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email
                                          FROM users u JOIN patients p ON u.id = p.user_id

                                          WHERE u.surnames = ?
                                          GROUP BY u.id', [$request->surname]);
            return $patients;
        }

        // Search for pending to check (checked == false)
        if (!$request->name && !$request->surname) {
            //return('solo checked');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email, ps.checked AS last_status_checked, max(ps.date)
                                          FROM users u JOIN patients p ON u.id = p.user_id
                                                       JOIN patient_states ps ON p.user_id = ps.patient_id
                                          WHERE ps.checked = ?
                                          GROUP BY u.id', [$request->checked]);
            return $patients;
        }

        // Search for name & surname
        if (!$request->checked) {
            //return('name & surname');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email
                                          FROM users u JOIN patients p ON u.id = p.user_id

                                          WHERE u.name = ? AND u.surnames = ?
                                          GROUP BY u.id', [$request->name, $request->surname]);
            return $patients;
        }

        // Search for name & pending to check
        if (!$request->surname) {
            //return('name & checked');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email, ps.checked AS last_status_checked, max(ps.date)
                                          FROM users u JOIN patients p ON u.id = p.user_id
                                                       JOIN patient_states ps ON p.user_id = ps.patient_id
                                          WHERE u.name = ? AND ps.checked = ?
                                          GROUP BY u.id', [$request->name, $request->checked]);
            return $patients;
        }

        // Search for surname & pending to check
        if (!$request->name) {
            //return('surname & checked');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email, ps.checked AS last_status_checked, max(ps.date)
                                          FROM users u JOIN patients p ON u.id = p.user_id
                                                       JOIN patient_states ps ON p.user_id = ps.patient_id
                                          WHERE u.surnames = ? AND ps.checked = ?
                                          GROUP BY u.id', [$request->surname, $request->checked]);
            return $patients;
        }

        // Search for name & surname & pending to check
        if ($request->name && $request->surname && $request->checked) {
            //return('name & surname & checked');
            $patients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, p.height, u.email, ps.checked AS last_status_checked, max(ps.date)
                                          FROM users u JOIN patients p ON u.id = p.user_id
                                                       JOIN patient_states ps ON p.user_id = ps.patient_id
                                          WHERE u.name = ? AND u.surnames = ? AND ps.checked = ?
                                          GROUP BY u.id', [$request->name, $request->surname, $request->checked]);
            return $patients;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
