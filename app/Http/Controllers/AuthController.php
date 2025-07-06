<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login_page()
    {
        // Auth::logout();
        return view('auth.login',['title' => 'Login Page']);
    }
    public function login(Request $request)
    {
         $attributes = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        // if(Auth::attempt($attributes)){
        //     return redirect(RouteServiceProvider::HOME);
        // }

        $user = User::where('username', $request->username)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                // dd($user);
                Auth::login($user); 
                return redirect(RouteServiceProvider::HOME);
                
            }else{
                throw ValidationException::withMessages([
                    'username' => 'Username atau password salah'
                ]);
            }
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login_page'));
    }
}
