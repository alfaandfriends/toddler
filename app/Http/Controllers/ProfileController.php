<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\School;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $school =   School::where('email', $request->user()->user_email)->first();
        $can_edit_profile   =   School::where('email', $request->user()->user_email)->exists();
        
        return Inertia::render('Profile/Edit', [
            'school'            => $school,
            'can_edit_profile'  => $can_edit_profile
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if($request->email == $request->user()->user_email){
            School::where('email', $request->user()->user_email)->update([
                'name' => $request->name
            ]);

            return back()->with(['type' => 'success', 'message' => 'Profile has been updated.']);
        }
        
        School::where('email', $request->user()->user_email)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        $request->user()->update([
            'user_email' => $request->email
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
