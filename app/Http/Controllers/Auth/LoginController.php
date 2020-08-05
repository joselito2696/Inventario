<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',['only'=>'showLoginForm']);
    }

    


    public function showloginForm(){
        return view('login.login');
    }
    public function login(){
        $credenciales=$this->validate(request(),[
            'email'=>'email|required|string',
            'password'=>'required|string'
        ]);
        if(Auth::attempt($credenciales)){
            return redirect()->route('home');
        }
        return back()->withErrors(['email'=>trans('auth.failed')])
        ->withInput(request(['email']));
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
