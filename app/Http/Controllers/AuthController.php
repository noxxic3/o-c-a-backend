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
        try {
            /*
            // Validation from the backend if the form fields were empty. In this case it is done on the frontend.
            $request->validate([
                ‘email’ => ‘email|required’,
                ‘password’ => ‘required’
            ]);
            */

            /*
            Authentication should check:
            1) That the email (identifier) that the user has entered exists, that is, that the user is registered.
            2) That the password entered is the correct one for that identifier.
            We could search the database directly by email and password, but in case the user is not found, we wouldn't know
            if the user is not found because the email does not exist or if the email exists but the password of this email does not match the one received.
            Knowing this is necessary to be able to send the correct error message to the frontend.
            */

            // STEP 1)

            /*
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {                   // Auth Facade  // attempt() method:  https://laravel.com/docs/8.x/authentication#authenticating-users   is in charge of looking for the user by email and by password but I think it looks for it encrypted, it has to be stored encrypted during registration.  The attempt method will return true if authentication was successful. Otherwise, false will be returned.
                return response()->json([                                         // That is, attempt() accesses the Users table, and therefore invokes the User class?
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

            // STEP 2)

            /*if ( ! Hash::check($request->password, $user->password, [])) {          // Hash::check()  i think it verifies the passwords but encrypted
                throw new Exception('Error in Login');
            }*/
            if ($user->password != $request->password){
                throw new Exception('Error in Login');
            }

            /*
            Here all the authentication validations must have already been executed. In this part of the code, the user exists and his password is correct.
            */

            /*
            Now the token is generated for the user.
            ->createToken() create it and save it in the personal_access_tokens table
            where tokenable_type and tokenable_id point to the corresponding table and id of the token owner.
            */

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            /*
            We now look for the data from the tables associated with User (User subtypes) in order to send the necessary data to the frontend.
            In this case, we just need to find at which User subtype table the user is in.
            */
            $user_subtype = Patient::where('user_id', $user->id)->first();
            if (!$user_subtype){
                $user_subtype = Doctor::where('user_id', $user->id)->first();
            }
            if (!$user_subtype){
                $user_subtype = OfficeStack::where('user_id', $user->id)->first();
            }
            if (!$user_subtype){
                $user_subtype = Admin::where('user_id', $user->id)->first();
            }

            // Return the necessary data of the authenticated user to the frontend.
            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
                'user_subtype' => $user_subtype,
            ]);

        } catch (Exception $error) {              // If an Exception is thrown in the try(){} block...
            return response()->json([
                'status_code' => 403,
                'message' => 'Error in Login. Incorrect password',
                'error' => $error,
            ]);
        }
    }

    public function logout($id)                  // logout() is not used to remove the user, that is done by the destroy() method of the UserController.
    {                                            // logout() just remove the token to log out the user, it makes the token no longer valid in the backend.
        // Delete the user's token
        $deleted = DB::delete('DELETE FROM personal_access_tokens WHERE tokenable_id = ?', [$id]);
    }

}
