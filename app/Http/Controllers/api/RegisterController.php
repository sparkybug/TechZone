<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class RegisterController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:employer');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|min:4',
            'lastname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'company_name' => 'required|min:4',
            'is_employer' => 'required',
            'company_rating' => 'required',
            'company_location' => 'required|min:4',
            'total_spent' => 'required',
        ]);

        $user = Employer::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        event(new Registered($user));
  
        $token = $user->createToken('Laravel8PassportAuth')->accessToken;
  
        return response()->json(['token' => $token], 200);
    }
}
