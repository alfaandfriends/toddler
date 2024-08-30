<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchController extends Controller
{
    public function launch($key){
        // dd($key);
        return view('toddler_web.index');
    }
}
