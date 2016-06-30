<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Auth;
use Hash;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }
    /**
     * Return the user
     *
     * @return Response
     */
    public function index()
    {
        // Retrieve all the users in the database and return them        
        $users = User::all();
        return $users;
    }
    /**
     * Return a JWT
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['username'] = $credentials['email'];
        unset($credentials['email']);

        // verify the credentials and create a token for the user
        // LOGIN LDAP 

        try {
            if ((Auth::guard("ldap")->attempt($credentials)))
            {
                $user_ldap = Auth::guard("ldap")->user()->getAdLDAP();

                unset($credentials['username']);
                $credentials['email'] = $user_ldap->getUserPrincipalName();


                $user_eloquent = User::where('email', '=', $credentials['email'])->first();
                // CHECK IF IS THE FIRST LOGIN
                if(empty($user_eloquent)){
                    // IS FIRST LOGIN -> REGISTER
                    $user_eloquent = new User;

                    $user_eloquent->name = $user_ldap->getDisplayName();
                    $user_eloquent->email = $credentials['email'];
                    $user_eloquent->password = Hash::make($credentials['password']);

                    $user_eloquent->save();
                }else{
                    // IS NOT FIRST LOGIN -> UPDATE PASSWORD
                    $user_eloquent->password = Hash::make($credentials['password']);

                    $user_eloquent->save();
                }
                try {
                    // GET TOKEN AND SESSION
                    if (!$token = JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'invalid_credentials'], 401);
                    }
                } catch(JWTException $e) {
                    // something went wrong
                    return response()->json(['error' => 'could_not_create_token'], 500);
                }
            }else{
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (\Exception $e) {
            // something went wrong
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
}