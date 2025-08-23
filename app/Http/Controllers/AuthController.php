<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;                
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{


    public function show()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }


    public function store(Request $request){
            $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:3']
        ]);
        
        $user=User::create($fields);

        Auth::login($user);
        
        return redirect()->route('dashboard');
    }





    public function login(Request $request)
    {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);
   
        // Try to login the user
        if(Auth::attempt($fields, $request->remember)){
               return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }else{
            return back()->withErrors([
                'remember'=> 'The provided credentials do not match our records.'
            ])->onlyInput('email');
        };

    }

    
}
