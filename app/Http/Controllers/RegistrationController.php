<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegistrationService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function show(): View
    {
        return view('authentication.register');
    }

    public function register(Request $request)
    {
        $result = (new RegistrationService())->generateEmailVerificationUrl([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'phone_number' => $request->phone_number,
            'city'         => $request->city,
            'state'        => $request->state,
            'country'      => $request->country,
            'address'      => $request->address,
            'email'        => $request->email,
            'password'     => $request->password
        ]);

        if ($result->isFailure())
            return back()->withErrors(['email' => $result->unwrapErr()]);

        
        return view('authentication.check-email');
    }

    public function verifyEmail(Request $request)
    {
        $result = (new RegistrationService())->verifyEmail([
            'email' => $request->email,
            'token' => $request->token
        ]);

        if ($result->isFailure())
            return view('authentication.expired-url');
        
        Auth::login($result->unwrap()['user']);
        return redirect('/');
    }
}
