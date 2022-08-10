<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getIndex(){
        // $pass=bcrypt("1234567890");
        return view("admin/pages/index");
    }
    //
    public function getLoginAdmin(){
        // dd($pass=bcrypt("1234567890"));
       // echo($pass);
        return view("admin/pages/loginadmin/login");
    }
    public function postLoginAdmin(Request $request){
        $remember=$request->has("remember_me")?true:false;
        // dd(auth()->guard('admin')->attempt([
        //     "email"=>$request->input("email"),
        //     "password"=>$request->input("password")
        // ],$remember));
        if( auth()->guard('admin')->attempt([
            "email"=>$request->input("email"),
            "password"=>$request->input("password")
        ],$remember)){
           return redirect()->to("admin");
        }

        return view("admin/pages/loginadmin/login");

    }
}
