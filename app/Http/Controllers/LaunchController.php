<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchController extends Controller
{   
    public function checkDevice($app_key, $app_token, Request $request){
        $key_info = Key::where('key', $app_key)->first();

        /* If all condition matched */
        if($request->confirm){
            return response()->json(['launch' => true]);
        }

        /* If first time launch */
        if(!$key_info->app_token){
            return response()->json(['first_device' => true]);
        }
        
        /* If new device detected */
        if($key_info->app_token != $app_token){
            /* If device last swap */
            if($key_info->swap_count == 2){
                return response()->json(['last_swap' => true, 'active_device_name' => $key_info->device_name]);
            }
            /* If device limit reached */
            if($key_info->swap_count == 3){
                return response()->json(['device_limit_reached' => true]);
            }
            return response()->json(['new_device' => true, 'active_device_name' => $key_info->device_name]);
        }
        
        /* If all condition matched */
        return response()->json(['launch' => true]);
    }

    public function launch(Request $request){
        $key_info = Key::where('key', $request->app_key)->first();
        
        if($request->device_name){
            Key::where('key', $request->app_key)->update([
                'device_name'   => $request->device_name,
                'app_token'     => $request->app_token,
                'swap_count'    => $key_info->swap_count + 1
            ]);
        }

        return view('toddler_web.index');
    }
}
