<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User is already verified'
            ], 200);
        }

        if ($request->user()->markEmailverified()) {
            event(new Verified($request->user()));
        }

        return response()->json([
            'message' => 'Email verified successfully'
        ], 200);
    }
}
