<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(){
        if (isset($_COOKIE['login'])) {
            return redirect()->route('home');
        }
        else{
            return view('user.login');
        }
    }

    public function register(){
        if (isset($_COOKIE['login'])) {
            return redirect()->route('home');
        }
        else{
            return view('user.register');
        }
    }

    public function logout(){
        setcookie('login', '', time() - 3600, "/");
        return redirect()->route('login');
    }
}
