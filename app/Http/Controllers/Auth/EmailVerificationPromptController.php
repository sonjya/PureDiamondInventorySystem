<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class usernameVerificationPromptController extends Controller
{
    /**
     * Display the username verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->hasVerifiedusername()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : Inertia::render('Auth/Verifyusername', ['status' => session('status')]);
    }
}
