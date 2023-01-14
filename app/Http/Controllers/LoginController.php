<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    //
    private $rules = [];
    private $messages = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

        $this->rules = [
            "username" => "required",
            "userpass" => "required"
        ];
        $this->messages = [
            "username.required" => "Username is required",
            "userpass.required" => "Password is required"
        ];
    }
    public function login(Request $req)
    {
        $user = "Admin";
        $pass = "pass";
        $validator = Validator::make($req->all(), $this->rules, $this->messages);
        if (!$validator->fails()) {
            $req->session()->put("session_username", $req->input("username"));
            return redirect('home');
        } else {
            return back()->withErrors($validator->errors())->withInput();
        }
    }



    /*public function login(Request $req)
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
    }*/
}
