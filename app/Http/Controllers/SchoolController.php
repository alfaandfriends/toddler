<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use App\Mail\KeyGenerated;
use App\Mail\PasswordReset;
use App\Models\Category;
use App\Models\Key;
use App\Models\Kit;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Str;
use MikeMcLin\WpPassword\Facades\WpPassword;


class SchoolController extends Controller
{
    public function index(Request $request){

        $schools   =   School::with([
            'categoryRef'
        ])
        ->when($request->search, function($query) use ($request){
            $query->where('name', 'LIKE', "%$request->search%")->orWhere('code', 'LIKE', "%$request->search%");
        })
        ->when($request->category_id, function($query) use ($request){
            $query->where('category_id', $request->category_id);
        })
        ->paginate(10);

        $options['categories']  =   Category::get();
        $options['kits']        =   Kit::get();
        
        return Inertia::render('Schools/Index', [
            'filters'  =>  request()->all('search', 'category_id'),
            'schools'  =>  $schools,
            'options'  =>  $options
        ]);
    }

    public function store(Request $request){

        /* Check for all data */
        $user   =   User::where('user_email', $request->email)->first();
        $school =   School::where('email', $request->email)->first();

        /* If dont have account, create one */
        if(!$user){
            $new_password           =   Str::random(8);
            $encoded_new_password   =   WpPassword::make($new_password);
            User::insert([
                'user_login' => Str::before($request->email, '@'),
                'user_pass' => $encoded_new_password,
                'user_nicename' => Str::before($request->email, '@'),
                'user_email' => $request->email,
                'display_name' => Str::before($request->email, '@'),
            ]);

            Mail::to($request->email)->send(new AccountCreated($request->email, $new_password));
        }

        /* If dont have school, create one*/
        $school_id = $school ? $school->id : '';
        if(!$school){
            $school_id = School::insertGetId([
                'category_id'   =>  $request->category,
                'name'          =>  $request->name,
                'code'          =>  $request->code,
                'email'         =>  $request->email,
            ]);
        }

        Key::where('school_id', $school_id)->delete();
        foreach($request->kits as $key=>$kit){
            if($kit['checked']){
                for($i = 0; $i < 2; $i++){
                    Key::insert([
                        'school_id' => $school ? $school->id : $school_id,
                        'key' => $request->code.'-'.Str::random(8),
                        'created_by' => Auth::id(),
                        'expiry_date' => Carbon::now()->endOfYear(),
                        'kit_id' => $kit['id'],
                    ]);
                }
            }
        }

        /* Send Email */
        // Mail::to($request->email)->send(new KeyGenerated($request->email, $new_password));
        
        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function edit(Request $request){
        $info   =   School::where('id', $request->school_id)->first();
        $keys   =   Key::with([
            'kitRef'
        ])
        ->where('school_id', $request->school_id)->paginate(10);

        return Inertia::render('Schools/Edit', [
            'info'  =>  $info,
            'keys'  =>  $keys
        ]);
    }

    public function destroy($id){
        School::where('id', $id)->delete();
        Key::where('school_id', $id)->delete();

        return redirect(route('schools'))->with(['type'=>"success", 'message'=>'School has been deleted.']);
    }

    public function info($code){
        $info   =   School::with('categoryRef')->where('code', $code)->first();

        return $info;
    }

    public function resetPassword($id){
        $owner_email    =   School::where('id', $id)->pluck('email')->first();


        $user = User::where('user_email', $owner_email)->first();

        if ($user) {
            $new_password           =   Str::random(8);
            $encoded_new_password   =   WpPassword::make($new_password);

            $user->timestamps = false;
            $user->user_pass = $encoded_new_password;
            $user->save(); // This will not update the `updated_at` column
        }
        // User::where('user_email', $owner_email)->updateQuietly([
        //     'user_pass' => $encoded_new_password, 
        // ]);

        /* Send Email */
        Mail::to($owner_email)->send(new PasswordReset($owner_email, $new_password));

        return redirect(route('schools'))->with(['type'=>"success", 'message'=>"Password has been reset and new password has been sent to owner's email."]);
    }

}
