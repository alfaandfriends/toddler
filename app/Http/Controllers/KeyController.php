<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    public function destroy($id){
        Key::where('id', $id)->delete();

        return back()->with(['type'=>"success", 'message'=>'Key has been deleted.']);
    }

    public function reset($id){
        Key::where('id', $id)->update([
            'swap_count' => 0
        ]);

        return back()->with(['type'=>"success", 'message'=>'Swap count has been reset.']);
    }
}
