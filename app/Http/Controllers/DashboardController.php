<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){

        $keys   =   Key::with([
            'kitRef',
            'schoolRef'
        ])
        ->paginate(10);
        
        return Inertia::render('Dashboard', [
            'keys'  =>  $keys
        ]);
    }
}
