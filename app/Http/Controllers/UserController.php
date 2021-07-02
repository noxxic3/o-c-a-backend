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
        //return $request;
        //return $request->input('user_name');
        //return $request->input('user_image');    // Es un objeto, pero si lo retornamos retorna una string vacía.
        //return $request->file('user_image');     // Nombre ruta completa archivo temporal subido al servidor:  "C:\\wamp64\\tmp\\phpE099.tmp"
        //return $request->file('user_image')->getClientOriginalName();    // Nombre del archivo original tal como lo subió el usuario.

        ////////////////////////////////////////////////////////////////       // ***********

        // Handle File Upload
        if( $request->hasFile('user_image') ){                                     // Verificamos si hay archivo, ya que puede ser que el usuario no haya adjuntado nada en el campo para archivo del formulario
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('user_image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo()  es una función de PHP, no de Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('user_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('user_image')->storeAs('public/images/patients', $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.svg';
        }

        ////////////////////////////////////////////////////////////////


        // Aquí se hará una inserción 'combinada' (a 2 tablas, como las consultas combinadas) con la tabla User + una de las subtablas dependiendo del rol

        // Insert into User
        $user = new User();
        $user->name = $request->input('user_name');
        $user->surnames = $request->input('user_surnames');
        $user->birthdate = $request->input('user_birthdate');
        $user->email = $request->input('user_email');
        $user->password = $request->input('user_password');
        $user->save();

        // Select last register from User to get the last id (the id of the user that we have just inserted)
        $user_id = DB::select('SELECT id FROM users WHERE id = (SELECT max(id) FROM users)');
        //return $user_id[0];    //<-- da error

        // Además, debemos gestionar el archivo en el caso del Patient
        if($request->role_name == 'Patient'){
            //return 'el rol recibido es '.$request->role_name;

            // Insert into Patient
            $patient = new Patient();
            $patient->user_id = $user_id[0]->id;
            $patient->height = $request->input('patient_height');
            $patient->role_name = $request->input('role_name');
            $patient->save();

            $user->image = $fileNameToStore;      // 'AAAAAAA';    //$request->input('user_image');    // ***********
            $user->save();
        }

        if($request->role_name == 'Doctor'){
            //return 'el rol recibido es '.$request->role_name;

            // Insert into Doctor
            $doctor = new Doctor();
            $doctor->user_id = $user_id[0]->id;
            $doctor->speciality = $request->input('doctor_specialty');
            $doctor->role_name = $request->input('role_name');
            $doctor->save();
        }

        if($request->role_name == 'OfficeStack'){
            //return 'el rol recibido es '.$request->role_name;

            // Insert into OfficeStack
            $officeStack = new OfficeStack();
            $officeStack->user_id = $user_id[0]->id;
            $officeStack->role_name = $request->input('role_name');
            $officeStack->save();
        }

        if($request->role_name == 'Admin'){
            //return 'el rol recibido es '.$request->role_name;

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
        /*  // Esta consulta era una prueba por si lo que se recibía era solo el ID como parámetro de ruta
        //$user = User::find($id);
        //return $user->patient;               // <<--- Al haber quitado las asociaciones del Eloquent ORM en el Modelo, ya no podemos consultar el Patient asociado al User desde la instancia User, pero sí podemos consultar al User.
        //return $user;

        //$users = DB::select('SELECT * FROM users u JOIN patients p ON u.id = p.user_id WHERE p.role_name = ?', [$id]);    // http://localhost/8_TFG/ObesityControlApp/public/api/users/Patient
        $users = DB::select('SELECT * FROM users u JOIN patients p ON u.id = p.user_id WHERE u.id = ?', [$id]);      // http://localhost/8_TFG/ObesityControlApp/public/api/users/1
        return $users;           // <<--  Array con objetos que el frontend recorre los elementos (objetos) del array
        */

        //return $request;
        ////////////////////////////////////////////////////


        // Search by Name
        if (!$request->surname) {
            //return 'Only name';

            //$users = búsqueda combinada Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.name = ?', [$request->name]);
            //return $usersPatients;

            //$users = búsqueda combinada Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.name = ?', [$request->name]);

            //$users = búsqueda combinada Users + OfficeStack
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.name = ?', [$request->name]);

            //$users = búsqueda combinada Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.name = ?', [$request->name]);
            //
            //Habría que agregar al array cada resultado
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);
            // Ordenar el array
            // usort() compare function: Since several independent combined queries are made between User and every subtype table, and then the resulting arrays will be added to a single array, we will need to sort it by ID so that the client receives it ordered.
            usort($users, function ($a, $b)              // Si pongo la función de comparación como función externa, dice que no encuentra el namespace... // https://stackoverflow.com/questions/38228477/php-usort-expects-parameter-2-to-be-a-valid-callback-not-in-a-class
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
            //Si al final, el array está vacío (se puede verificar en el frontend), es que no se ha encontrado nada
        }

        // Search by Surname
        if (!$request->name) {
            //return 'Only surname';

            //$users = búsqueda combinada Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.surnames = ?', [$request->surname]);
            //return $usersPatients;

            //$users = búsqueda combinada Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            //$users = búsqueda combinada Users + OfficeStack
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.surnames = ?', [$request->surname]);

            //$users = búsqueda combinada Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.surnames = ?', [$request->surname]);
            //
            //Habría que agregar al array cada resultado
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);
            // Ordenar el array
            usort($users, function ($a, $b)
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
            //Si al final, el array está vacío (se puede verificar en el frontend), es que no se ha encontrado nada
        }

        // Search by Name & Surname
        if ($request->name && $request->surname) {
            //return 'name & surname';

            //$users = búsqueda combinada Users + Patients
            $usersPatients = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, p.role_name, p.height
                                       FROM users u
                                       JOIN patients p ON u.id = p.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);
            //return $usersPatients;

            //$users = búsqueda combinada Users + Doctors
            $usersDoctors = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, d.role_name, d.speciality
                                       FROM users u
                                       JOIN doctors d ON u.id = d.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            //$users = búsqueda combinada Users + OfficeStack
            $usersOfficeStack = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, o.role_name
                                       FROM users u
                                       JOIN office_stacks o ON u.id = o.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);

            //$users = búsqueda combinada Users + Admin
            $usersAdmin = DB::select('SELECT u.id, u.image, u.name, u.surnames, u.birthdate, u.email, u.password, a.role_name
                                       FROM users u
                                       JOIN admins a ON u.id = a.user_id
                                       WHERE u.name = ? AND u.surnames = ?', [$request->name, $request->surname]);
            //
            //Habría que agregar al array cada resultado
            $users = array_merge($usersPatients, $usersDoctors, $usersOfficeStack, $usersAdmin);
            // Ordenar el array
            usort($users, function ($a, $b)
                {
                    if ($a->id == $b->id) {
                        return 0;
                    }
                    return ($a->id < $b->id) ? -1 : 1;
                }
            );
            return $users;
            //Si al final, el array está vacío (se puede verificar en el frontend), es que no se ha encontrado nada
        }

    }
    /*
    public function show(User $user)
    {
        return $user;            // <<--  Objeto que el frontend recorre sus propiedades
    }
    */
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
    public function update(Request $request, $id, $role)    // Aquí es rep per defecte $request i $id, on $id és necessari per a saber quin registre actualitzar. En aquest cas, segons el rol de l'usuari també necessitarem actualitzar alguna dada de les SubTaules d'Usuari. Encara que el rol el podiem haver rebut també en l'objecte $request, aquesta no és una dada per a actualitzar sino que ens serveix també com a identificador alternatiu per a saber en quina taula cal actualitzar les dades especialitzades del rol al qual pertany l'usuari.  Per tant, l'enviem també com a paràmetre en la ruta, de la mateixa manera que ho fem amb el mètode destroy().
    {
        //return $request->input('user_name');

        ////////////////////////////////////////////////////////////////       // ***********

        // Handle File Upload
        if( $request->hasFile('user_image') ){                                     // Verificamos si hay archivo, ya que puede ser que el usuario no haya adjuntado nada en el campo para archivo del formulario
            // Get the filename with the extension, for example:   nameImage.jpg
            $fileNameWithExt = $request->file('user_image')->getClientOriginalName();
            // Get just filename, for example:   nameImage
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);          // pathinfo()  es una función de PHP, no de Laravel. Extract the fileName without the extension
            // Get just extension, for example:   .jpg
            $extension = $request->file('user_image')->getClientOriginalExtension();
            // FileName to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            // Upload image file to the destination folder
            $path = $request->file('user_image')->storeAs('public/images/patients', $fileNameToStore);
        } // si el usuario no sube ninguna foto nueva en los datos de modificación, no vamos a poner la foto por defecto sino que debemos mantener la antigua.

        ////////////////////////////////////////////////////////////////

        // update en User con el ID
        $affected = DB::table('users')       // $affected:  The number of rows affected by the statement will be returned
        ->where('id', '=', $id)
            ->update(
                [
                    'name' => $request->input('user_name'),
                    'surnames' => $request->input('user_surnames'),
                    'birthdate' => $request->input('user_birthdate'),
                    'email' => $request->input('user_email'),
                    'password' => $request->input('user_password'),
                    //'image' => $request->input('user_image'),               // *********
                ]);

        // si es Patient o Doctor, update en las tablas Patient o Doctor
        if($role == 'Patient'){
            //return 'The role is Patient!';

            $affected = DB::table('patients')
            ->where('user_id', '=', $id)
                ->update(['height' => $request->input('patient_height')]);

            // Si se ha subido una foto nueva del paciente, se actualiza el campo image del usuario paciente con el nuevo nombre de imagen
            if( $request->hasFile('user_image') ){
                // Primero borramos el archivo de imagen antiguo que pertenecía a este paciente
                $user = User::find($id);
                if($user->image != 'noImage.svg'){            // Solo borramos la imagen anterior que había si no era la imagen por defecto, ya que esa la usan otros registros
                    // Delete image file
                    Storage::delete('public/images/patients/'.$user->image);        // ruta   storage/app/public/images/patients/
                }
                // A continuación actualizamos el valor del campo image del usuario paciente.
                $affected = DB::table('users')
                ->where('id', '=', $id)
                    ->update(['image' => $fileNameToStore ]);
            }

            } else if ($role == 'Doctor'){
            //return 'The role is Doctor!';

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
        //return 'UserController@destroy! - Role: ' . $role;

        // Si no recibo el rol del usuario, aqui tendría que buscar en cada SubTipo de User si se encuentra el ID recibido, y si lo encuentra, borrar el registro en la tabla en la que se encuentre.
        // Si hiciéramos que sea el Controlador del SubTipo el que se encargue de eso, el frontend tendría que hacer la petición a 4 posibles rutas diferentes según el rol, además de la de User.
        // Si hacemos que se encargue UserController, si recibe el rol además del ID, solo tendrá que borrar en la tabla correspondiente del rol.
        // Recuerda que además hay que borrar los registros que tenga asociados de otras tablas y hay que hacerlo por orden

        if($role == 'Patient'){
            /*$patientTreatment = PatientTreatment::where($id);      // Eloquent ORM busca por defecto en la columna 'id', si la PK es otra hay que especificarlo en el modelo, pero no lo hago porque puedo tener otras consultas que queden afectadas.
            $patientTreatment->delete();*/

            $deleted = DB::delete('DELETE FROM patient_treatments WHERE patient_id = ?', [$id]);

            /*$patientStates = PatientStates::where($id);
            $patientStates->delete();*/

            $deleted = DB::delete('DELETE FROM patient_states WHERE patient_id = ?', [$id]);

            /*$patient = Patient::find($id);
            $patient->delete();*/

            $deleted = DB::delete('DELETE FROM patients WHERE user_id = ?', [$id]);

        } else if ($role == 'Doctor'){
            /*$doctor = Doctor::find($id);
            $doctor->delete();*/
            $deleted = DB::delete('DELETE FROM doctors WHERE user_id = ?', [$id]);

            // Habría que borrar también el valor de la columna doctor del registro correspondiente de la tabla PatientTreatments
            $affected = DB::table('patient_treatments')
            ->where('doctor', '=', $id)
            ->update(['doctor' => null]);

        } else if($role == 'OfficeStack'){
            /*$officeStack = OfficeStack::find($id);
            $officeStack->delete();*/
            $deleted = DB::delete('DELETE FROM office_stacks WHERE user_id = ?', [$id]);
        } else if($role == 'Admin'){
            /*$admin = Admin::find($id);
            $admin->delete();*/
            $deleted = DB::delete('DELETE FROM admins WHERE user_id = ?', [$id]);
        }

        // Borramos el token de sesión del usuario
        $deleted = DB::delete('DELETE FROM personal_access_tokens WHERE tokenable_id = ?', [$id]);

        // Borramos el usuario
        $user = User::find($id);

        // Cuando vamos a eliminar el usuario hay que borrar también la imagen de usuario que este subió.
        // Solo eliminaremos el archivo de imagen del paciente si este no es 'noImage.svg' o null.
        // En los usuarios que no són pacientes es null, con lo cual, no tienen imagen asociada y entonces tampoco hay que borrar nada.
        if($user->image != 'noImage.svg'){
            // Delete image file
            Storage::delete('public/images/patients/'.$user->image);        // ruta   storage/app/public/images/patients/
        }

        $user->delete();

    }
}
