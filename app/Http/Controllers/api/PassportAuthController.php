<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Middleware\AuthenticateSession;

class PassportAuthController extends Controller
{
    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|min:4',
            'lastname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
  
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now()
        ]);

        // event(new Registered($user));

        // $user->sendEmailVerificationNotification();

        $user->markEmailAsVerified();
  
        $token = $user->createToken('Laravel8PassportAuth')->accessToken;
  
        return response()->json(['token' => $token], 200);
    }
  
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
  
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function userInfo()
    {
        // Check if the user is authenticated via the access token
        // if (Auth::check()) {
        //     $user = Auth::user();
        //     return response()->json(['user' => $user], 200);
        // } else {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

         // Get the authenticated user
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Return the user information in the response
    return response()->json(['user' => $user], 200);
    }
 
    public function user_Info($id) 
    {
        // retrieving user by ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
      
        return response()->json(['user' => $user], 200);
    }

    /**
     * Log the user out of the application
     */
    public function logout(Request $request)
    {
        // Auth::logout();

        // $request->session()->invalidate();

        // Auth::userInfo()->token()->revoke();

        $user = $request->user();
        $user->token()->revoke();

        return response()->json(['User successfully Logged out']);

        // Auth::logoutOtherDevices($password);

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return redirect('/');
    }
}


