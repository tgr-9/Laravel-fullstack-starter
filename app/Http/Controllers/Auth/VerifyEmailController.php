<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return $request->expectsJson()
            ? response()->json(['status' => 'OK'])
            : redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
