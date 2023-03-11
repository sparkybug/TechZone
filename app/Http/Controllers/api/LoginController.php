<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Employer;
use Illuminate\Auth\Events\Registered;
use Auth;

class LoginController extends Controller
{
    //
    public function __construct() 
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:employer')->except('logout');
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('employer')->attempt($credentials)) {
            $token = $request->user('employer')->createToken('Employer Access Token')->accessToken;

            return ['token' => $token];
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
