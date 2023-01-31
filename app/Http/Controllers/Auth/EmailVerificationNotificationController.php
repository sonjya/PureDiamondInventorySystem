<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class usernameVerificationNotificationController extends Controller
{
    /**
     * Send a new username verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedusername()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendusernameVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
