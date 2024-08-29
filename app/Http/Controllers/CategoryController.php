<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function update(Request $request){
        Category::where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return back()->with(['type' => 'success', 'message' => 'Data has been saved.']);
    }
}
