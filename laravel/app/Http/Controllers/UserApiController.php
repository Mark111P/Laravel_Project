<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function checkLogin(Request $request){
        $login = $request->get('login');
        $password = $request->get('password');

        $response = [];

        $users = User::all();
        if (count($users->where('login', $login)) > 0) {
            if ($users->where('login', $login)->value('password') == $password) {
                $response['status'] = 'ok';
                $response['role'] = $users->where('login', $login)->value('role');
                $response['login'] = $login;
            }
            else{
                $response['status'] = 'passwordError';
            }
        }
        else{
            $response['status'] = 'loginError';
        }

        return json_encode($response);
    }

    public function checkRegister(Request $request){
        $name = $request->get('name');
        $login = $request->get('login');
        $password = $request->get('password');

        $response = [];

        $users = User::all();
        if (count($users->where('login', $login)) == 0) {
            $user = new User();
            $user->name = $name;
            $user->login = $login;
            $user->password = $password;
            $user->role = 'user';
            $user->save();

            $response['status'] = 'ok';
        }
        else{
            $response['status'] = 'loginError';
        }

        return json_encode($response);
    }
}
