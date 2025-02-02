<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email , 'password'=>$request->password])){

            }
            else{
                return redirect()->route('account.login')->with('Your Email or Password is incorrect');
            }

        }
        else{
            return redirect()->route('account.login')->withErrors($validator)->withInput();
        }


    }

    public function register(){
        return view('register');
    }


    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users',//here users are our table name 
            'password'=>'required|confirmed',
        ]);

        if($validator->passes()){
           $user = new User();
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = Hash::make($request->password); //encrypt our password
           $user->role = 'user';
           $user->save();
           return redirect()->route('account.login')->with('You have been registered successfully');


        }
        else{
            return redirect()->route('account.register')->withErrors($validator)->withInput();
        }


    }

}
