<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\RegistersAdmins;
use Illuminate\Foundation\Auth\AuthenticatesAdmins;
use Illuminate\Http\Request;

class EmployerAuthController extends Controller
{
    use RegistersAdmins, AuthenticatesAdmins;
    //
}
