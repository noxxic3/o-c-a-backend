<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\OfficeStack;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        return $users;

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
        //return $request->input('user_image');    // It is an object, but if we return it, it returns an empty string.
        //return $request->file('user_image');     // Full path name of temporary file uploaded to the server:  "C:\\wamp64\\tmp\\phpE099.tmp"
        //return $request->file('user_image')->getClientOriginalName();    // Name of the original file as uploaded by the user.


        // Handle File Upload
        if( $request->hasFile('user_image') ){                                     // Check if there is a file
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('user_image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo() is PHP, not Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('user_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('user_image')->storeAs('public/images/patients', $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.svg';
        }

        // Next, a 'combined' insert will be made (to 2 tables, like the combined queries) with the User table plus one of the subtables depending on the role.

        // Insert into User
        $user = new User();
        $user->name = $request->input('user_name');
        $user->surnames = $request->input('user_surnames');
        $user->birthdate = $request->input('user_birthdate');
        $user->email = $request->input('user_email');
        $user->password = $request->input('user_password');
        $user->save();

        // Select the last record from User in order to get the last id (the id of the user that we have just inserted)
        $user_id = DB::select('SELECT id FROM users WHERE id = (SELECT max(id) FROM users)');

        // If User is Patient
        if($request->role_name == 'Patient'){
            // Insert into Patient
            $patient = new Patient();
            $patient->user_id = $user_id[0]->id;
            $patient->height = $request->input('patient_height');
            $patient->role_name = $request->input('role_name');
            $patient->save();
            // We must manage the image file in the case of the Patient role
            $user->image = $fileNameToStore;      // $request->input('user_image');
            $user->save();
        }

        // If User is Doctor
        if($request->role_name == 'Doctor'){
            // Insert into Doctor
            $doctor = new Doctor();
            $doctor->user_id = $user_id[0]->id;
            $doctor->speciality = $request->input('doctor_specialty');
            $doctor->role_name = $request->input('role_name');
            $doctor->save();
        }

        // If User is OfficeStaff
        if($request->role_name == 'OfficeStack'){
            // Insert into OfficeStack
            $officeStack = new OfficeStack();
            $officeStack->user_id = $user_id[0]->id;
            $officeStack->role_name = $request->input('role_name');
            $officeStack->save();
        }

        // If User is Admin
        if($request->role_name == 'Admin'){
            // Insert into Admin
            $admin = new Admin();
            $admin->user_id = $user_id[0]->id;
            $admin->role_name = $request->input('role_name');
            $admin->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)          // $id
    {

        // Search by Name
        if (!$request->surname) {

            // Combined query Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.name = ?', [$request->name]);

            // Combined query Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.name = ?', [$request->name]);

            // Combined query Users + OfficeStaff
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.name = ?', [$request->name]);

            // Combined query Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.name = ?', [$request->name]);

            // Add each query result to an array
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);

            // Sort the array
            // usort() compare function: Since several independent combined queries are made between User and every subtype table, and then the resulting arrays will be added to a single array, we will need to sort it by ID so that the client receives it ordered.
            usort($users, function ($a, $b)              // If I put the compare function as external function, it says it can't find the namespace... // https://stackoverflow.com/questions/38228477/php-usort-expects-parameter-2-to-be-a-valid-callback-not-in-a-class
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
            // If finally, the array is empty, nothing has been found. In this case that is being verified in the frontend, it should be done here.
        }

        // Search by Surname
        if (!$request->name) {

            // Combined query Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            // Combined query Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            // Combined query Users + OfficeStack
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            // Combined query Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            // Add each query result to an array
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);

            // Sort the array
            usort($users, function ($a, $b)
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
        }

        // Search by Name & Surname
        if ($request->name && $request->surname) {

            // Combined query Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            // Combined query Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            // Combined query Users + OfficeStack
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            // Combined query Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            // Add each query result to an array
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);

            // Sort the array
            usort($users, function ($a, $b)
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $role)    // Here we get $request and $id, where $id is needed to know which record to update. In this case, depending on the role of the user, we will also need to update some data in the User SubTables. Although the role could also have been received in the $request object, this is not a data to update but serves as an alternative identifier to know in which table it is necessary to update the specialized data of the role to which the user belongs. Therefore, we also send it as a parameter in the route, just as we do in the destroy() method.
    {
        // Handle File Upload
        if( $request->hasFile('user_image') ){                                     // Check if there is a file, in the edit form it is not mandatory
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('user_image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension, for example:   .jpg
            $extension = $request->file('user_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('user_image')->storeAs('public/images/patients', $fileNameToStore);
        } // If the user does not upload a new image in the update data, we will not set the default image but we must keep the old one.


        // Update User table with the ID
        $affected = DB::table('users')
        ->where('id', '=', $id)
            ->update(
                [
                    'name' => $request->input('user_name'),
                    'surnames' => $request->input('user_surnames'),
                    'birthdate' => $request->input('user_birthdate'),
                    'email' => $request->input('user_email'),
                    'password' => $request->input('user_password'),
                    //'image' => $request->input('user_image'),               // The image is only stored or updated in the Patient role
                ]);

        // If the user is Patient or Doctor, update the Patient or Doctor tables (which are the only ones that have additional fields)
        if($role == 'Patient'){

            $affected = DB::table('patients')
            ->where('user_id', '=', $id)
                ->update(['height' => $request->input('patient_height')]);

            // If a new image of the patient has been uploaded, the image field of the patient user is updated with the new image name
            if( $request->hasFile('user_image') ){
                // First we delete the old image file that belonged to this patient
                $user = User::find($id);
                if($user->image != 'noImage.svg'){            // We only delete the previous image stored if it was not the default role image, since that is used by other records
                    // Delete image file
                    Storage::delete('public/images/patients/'.$user->image);        //  storage/app/public/images/
                }
                // Next we update the value of the image field of the patient user.
                $affected = DB::table('users')
                ->where('id', '=', $id)
                    ->update(['image' => $fileNameToStore ]);
            }

        } else if ($role == 'Doctor'){
            $affected = DB::table('doctors')
                ->where('user_id', '=', $id)
                ->update(['speciality' => $request->input('doctor_specialty')] );
        }

        // recuerda que los datos para estas SubTablas los recibimos del frontend pero estos son nuevos, hay que hacer que el frontend los reciba del método show()
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $role)
    {
        /*
        If I do not receive the role of the user, here I would have to search in each SubType of User if the received ID is found, and if it finds it, delete the record in the table in which it is found.
        If we make the SubType Controller take care of that, the frontend would have to make the request to 4 different possible routes depending on the role, in addition to the User.
        If we make the UserController take care of it, if it receives the role in addition to the ID, it will only have to delete in the corresponding table of the role.
        Remember that it is also necessary to delete the records associated with it from other tables and it must be done in order.
        */

        if($role == 'Patient'){
            /*$patientTreatment = PatientTreatment::where($id);      // Eloquent ORM searches by default in the 'id' column, if the PK is another it must be specified in the model, but I don't do it because I may have other queries that are affected.
            $patientTreatment->delete();*/

            $deleted = DB::delete('DELETE FROM patient_treatments WHERE patient_id = ?', [$id]);
            $deleted = DB::delete('DELETE FROM patient_states WHERE patient_id = ?', [$id]);
            $deleted = DB::delete('DELETE FROM patients WHERE user_id = ?', [$id]);

        } else if ($role == 'Doctor'){
            $deleted = DB::delete('DELETE FROM doctors WHERE user_id = ?', [$id]);

            // The value of the doctor column of the corresponding record of the PatientTreatments table must also be deleted.
            $affected = DB::table('patient_treatments')
            ->where('doctor', '=', $id)
            ->update(['doctor' => null]);

        } else if($role == 'OfficeStack'){
            $deleted = DB::delete('DELETE FROM office_stacks WHERE user_id = ?', [$id]);
        } else if($role == 'Admin'){
            $deleted = DB::delete('DELETE FROM admins WHERE user_id = ?', [$id]);
        }

        // Delete the user's session token
        $deleted = DB::delete('DELETE FROM personal_access_tokens WHERE tokenable_id = ?', [$id]);

        // Delete the user
        $user = User::find($id);

        /*
        When we are going to delete the user, we must also delete the user image that the user uploaded.
        We will only delete the patient's image file if it is not 'noImage.svg' or null. In users who are not patients, it is null, which means that they do not have an associated image and therefore nothing has to be deleted.
        */

        if($user->image != 'noImage.svg'){
            // Delete image file
            Storage::delete('public/images/patients/'.$user->image);        //   storage/app/public/images/
        }

        $user->delete();

    }
}
