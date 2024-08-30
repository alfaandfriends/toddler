<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchController extends Controller
{   
    public function checkStatus($key, Request $request){
        $key_info   =   Key::where('key', $key)->first();
        if($key_info->user_agent != $request->user_agent){
            Key::where('key', $key)->update([
                'user_agent' => $request->user_agent,
                'ip_address' => $request->ip(),
            ]);
            dd($key_info);
        }
        return $key_info;
    }

    public function launch($key){
        return view('toddler_web.index');
    }
}
