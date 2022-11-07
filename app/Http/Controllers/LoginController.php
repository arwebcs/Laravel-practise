<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function login(Request $req)
    {
        $user = "Admin";
        $pass = "pass";
        $req->validate([
            "username" => "required|in:$user",
            "userpass" => "required|in:$pass",
        ]);
        $username = $req->input("username");
        $userpass = $req->input("userpass");
        if ($username == $user && $userpass == $pass) {
            $req->session()->put("session_username", $username);
            return redirect('home');
        } else {
            return view('login', ["datas" => $req->input()]);
        }
    }
}
