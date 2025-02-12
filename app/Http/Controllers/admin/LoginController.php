<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // this method will return the login view for admin
    public function adminLogin()
    {
        return view('admin.login');
    }

    // this method will authenticate the admin 
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if($validator->passes()){
            if(Auth::guard('admin')->attempt(['email'=>$request->email , 'password'=>$request->password])){

                if(Auth::guard('admin')->user()->role == 'admin'){
                    return redirect()->route('admin.dashboard'); 
                }
                else{
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error','You are not authorized to login');

                }   

                // return redirect()->route('admin.dashboard'); 
            }
            else{
                return redirect()->route('admin.login')->with('error','Your Email or Password is incorrect');
            }

        }
        else{
            return redirect()->route('admin.login')->withErrors($validator)->withInput();
        }


    }

    // this method will logout the admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

}
