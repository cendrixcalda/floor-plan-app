<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Http\Controllers\HomeController;
// use Illuminate\Support\Facades\Auth;

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

            // if (Auth::attempt(['username' => $username, 'password' => $password])) {
            //     // Authentication passed...
            //     // return redirect()->intended('dashboard');
            //     $notifMessage = "Logged In.";
            //     $notifType = "success";
            // } else {
            //     $notifMessage = "Invalid username/password.";
            //     $notifType = "error";
            // }
            $account = Account::where('username', $username)
            ->where('password', $password)
            ->first();

            if(!$account) {
                $notifMessage = "Invalid username/password.";
                $notifType = "error";

                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            } else {
                // $notifMessage = "Logged In.";
                // $notifType = "success";

                return redirect()->action([HomeController::class, 'show']);

            }
        } else {
            return view('login');
        }
    }
}
