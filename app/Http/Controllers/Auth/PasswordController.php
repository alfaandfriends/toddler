<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use MikeMcLin\WpPassword\Facades\WpPassword;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required'],
            'password_confirmation' => ['required'],
        ]);

        if(!WpPassword::check($request->current_password, $request->user()->user_pass)){
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        if($request->password != $request->password_confirmation){
            return back()->withErrors(['password' => 'The password does not match.', 'password_confirmation' => 'The password does not match.']);
        }

        $request->user()->update([
            'user_pass' => WpPassword::make($request->password),
        ]);

        return back()->with(['type' => 'success', 'message' => 'Password has been updated.']);
    }
}
