<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LaunchController extends Controller
{
    public function launch($key){
        return Inertia::render('AppPlayer/Index');
    }
}
