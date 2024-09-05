<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use MikeMcLin\WpPassword\Facades\WpPassword;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'min:8'],
            'password_confirmation' => ['required', 'min:8'],
        ]);

        if(!WpPassword::check($request->current_password, $request->user()->user_pass)){
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        if($request->password != $request->password_confirmation){
            return back()->withErrors(['password' => 'The password does not match.', 'password_confirmation' => 'The password does not match.']);
        }
        
        $user_email    =   User::where('id', $request->user()->ID)->pluck('user_email')->first();
        
        $new_password           =   $request->password;
        $encoded_new_password   =   WpPassword::make($new_password);

        User::where('user_email', $user_email)->update([
            'user_pass' => $encoded_new_password, 
        ]);

        return redirect(route('profile.edit'))->with(['type' => 'success', 'message' => 'Password has been updated.']);
    }
}
