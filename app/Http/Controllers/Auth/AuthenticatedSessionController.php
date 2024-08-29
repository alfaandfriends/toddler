<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use MikeMcLin\WpPassword\Facades\WpPassword;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_email' => ['required', 'email'],
            'user_pass' => ['required'],
        ]);

        $user = User::where('user_email', $request->user_email)->first();

        if ($user) {
            // Retrieve the hashed password from the database
            $current_password = $user->user_pass;

            // Check the password using the custom algorithm
            if (WpPassword::check($request->user_pass, $current_password)) {
                // Manually log in the user
                Auth::login($user, $request->remember);

                $client = new Client();
                try {
                    // Make a GET request to the OpenWeather API
                    $response = $client->get(env('TODDLER_API_URL').env('TODDLER_API_ENDPOINT').Auth::user()->ID);
        
                    // Get the response body as an array
                    $data = json_decode($response->getBody(), true);

                    if(in_array('administrator', $data)){
                        session(['is_admin' => true]);
                    }
                } catch (\Exception $e) {
                    Log::error($e);
                }

                // Regenerate the session to prevent session fixation attacks
                $request->session()->regenerate();

                // Redirect to the intended page
                return redirect()->intended('dashboard');
            }
        }
 
        return back()->withErrors([
            'user_email' => 'The provided credentials do not match our records.',
        ])->onlyInput('user_email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
