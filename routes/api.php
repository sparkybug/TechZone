<?php

use App\Http\Controllers\api\AssignmentController;
use App\Http\Controllers\api\DeclineJobController;
use App\Http\Controllers\VerificationController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\api\PassportAuthController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\SavedJobController;
use Illuminate\Session\Middleware\AuthenticateSession;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout']);

Route::post('employer/register', [RegisterController::class, 'register']);
Route::post('employer/login', [LoginController::class, 'login']);

Route::get('get-user/{id}', [PassportAuthController::class, 'user_Info']);

// Route::get('get-user-info', [PassportAuthController::class, 'userInfo']);

Route::middleware('auth.basic')->get('/get-user-info', 'PassportAuthController@userInfo');

Route::middleware('auth:api')->group(function () {
    Route::get('get-employer', [PassportAuthController::class, 'EmployerInfo']);
});

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [PassportAuthController::class, 'logout']);
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    // return redirect('/home');
    return response()->json(['message' => 'Email verified']);
    return back()->with('message', 'Email Verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

// Job-posting route
Route::post('/jobs', [JobsController::class, 'store']);
Route::get('/jobs', [JobsController::class, 'index']);
Route::get('/jobs/{id}', [JobsController::class, 'show']);
Route::put('/jobs/{id}', [JobsController::class, 'update']);
Route::delete('/jobs/{id}', [JobsController::class, 'destroy']);
Route::get('user/{user}/saved-jobs', [JobsController::class, 'getSavedJobsPerUser']);

// Route for Assigning jobs
Route::middleware('auth:api')->group(function() {
    Route::post('assign-job', [AssignmentController::class, 'assignJobs']);

    Route::get('user/{user}/jobs', [AssignmentController::class, 'getUserJobs']);

    Route::post('decline-job', [DeclineJobController::class, 'declineJob']);
});

// Routes for saved-jobs
Route::resource('saved-jobs', SavedJobController::class);


