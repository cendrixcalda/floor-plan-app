<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        return view('login');
    }

    public function submit(Request $request){
        $data = $request->post();

        if(isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];

            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                $request->session()->regenerate();

                return redirect()->intended();
            } else {
                $notifMessage = "Invalid username/password.";
                $notifType = "error";

                return redirect()->route('login')->with(["username" => $username, "password" => $password, "notifMessage" => $notifMessage, "notifType" => $notifType]);
            }
        } else {
            return view('login');
        }
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
}
