<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\OfficeStack;
use App\Models\Patient;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        //return $request;

        try {
            /*    // Validación desde el backend de si los campos del formulario estaban vacíos. En nuestro caso se hace en el frontend.
            $request->validate([
                ‘email’ => ‘email|required’,
                ‘password’ => ‘required’
            ]);
            */

            // La autenticación consiste en:
            //   1) Que exista el mail (identificador) que el usuario ha introducido, es decir, que esté registrado.
            //   2) Que el password que ha introducido sea el correcto para ese identificador.
            // Se podría buscar en la BD directamente por mail y password, pero en caso que no lo encuentre no sabríamos...
            // ...si es porque el email no existe o si existe pero el password de este email no coincide con el recibido.
            // Saber eso es necesario para poder enviar al frontend el mensaje de error correcto y que este informe al usuario.

            // 1)

            /*
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {                   // Auth Facade  // attempt() method:  https://laravel.com/docs/8.x/authentication#authenticating-users  se encarga de buscar el usuario por el email y por el password pero creo que lo busca encriptado, se tiene que guardar encriptado durante el registro.  The attempt method will return true if authentication was successful. Otherwise, false will be returned.
                return response()->json([                                         // Es decir, attempt() accede a la tabla Users, y por lo tanto, invoca a la clase User?
                    'status_code' => 401,
                    'message' => 'Unauthorized kkk'
                ]);
            }*/
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'User not found'
                ]);
            }

            // 2)

            /*if ( ! Hash::check($request->password, $user->password, [])) {          // Hash::check()  creo que verifica los passwords encriptados
                throw new Exception('Error in Login');                                        // En el ejemplo original pone   throw new \Exception, si lo hace así no hace falta poner  use Exception  arriba.   https://stackoverflow.com/questions/41415095/exception-class-not-found-in-laravel
            }*/
            if ($user->password != $request->password){
                throw new Exception('Error in Login');
            }

            // Aquí ya se deben de haber ejecutado todas las validaciones de autenticación...
            // ...para estar seguros que si llega a esta parte del código el usuario existe y su password es correcto.

            // Se genera el token para el usuario.
            //  ->createToken() lo crea y lo guarda en la tabla  personal_access_tokens,
            // donde tokenable_type y tokenable_id apuntan a la tabla e id correspondientes.

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Buscamos ahora los datos de las tablas asociadas a User para poder enviar al frontend los datos necesarios.
            // En este caso solo hay que mirar en qué tabla subtipo de User se encuentra el usuario.
            $user_subtype = Patient::where('user_id', $user->id)->first();
            if(!$user_subtype){
                $user_subtype = Doctor::where('user_id', $user->id)->first();
            }                                                                  // Poner un  else if  aquí ya no funcionaría porque la condición es la misma en todos y si se ha ejecutado ya el primer  if  , entonces los otros  else  ya no se ejecutan.
            if (!$user_subtype){
                $user_subtype = OfficeStack::where('user_id', $user->id)->first();
            }
            if (!$user_subtype){
                $user_subtype = Admin::where('user_id', $user->id)->first();
            }

            // Retornamos los datos necesarios del usuario autenticado al frontend.
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
                'user_subtype' => $user_subtype,
            ]);

        } catch (Exception $error) {              // Si se genera una Exception en el bloque try{}...
            return response()->json([
                'status_code' => 403,
                'message' => 'Error in Login. Incorrect password',
                'error' => $error,
            ]);
        }
    }

    public function logout($id)                  // logout() no es para eliminar al usuario, eso lo hace el método destroy() del UserController.
    {                                            // logout() solo elimina el token para cerrar sesión del usuario, que el token ya no sea válido en el backend.
        //return 'ID del usuario a borrar su token: '. $id;
        $deleted = DB::delete('DELETE FROM personal_access_tokens WHERE tokenable_id = ?', [$id]);
    }

}
