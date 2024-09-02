<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchController extends Controller
{   
    public function checkStatus($key, Request $request){
        $key_info = Key::where('key', $key)->first();
    
        if ($request->proceed) {
            Key::where('key', $key)->update([
                'app_token' => $request->app_token,
                'swap_count' => $key_info->swap_count + 1
            ]);
            return redirect()->route('launch');
        }

        if ($key_info->app_token != $request->app_token) {
            if ($key_info->swap_count == 2) {
                return response()->json(100);
            }

            Key::where('key', $key)->update([
                'app_token' => $request->app_token,
                'swap_count' => $key_info->swap_count + 1
            ]);
        }
        
        return response()->json(200);
    }

    public function launch(Request $request){
        return view('toddler_web.index');
    }
}
