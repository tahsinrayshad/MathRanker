<?php

namespace App\Http\Controllers\fe;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\Solver;

class login_controller extends Controller
{
    public function index()
    {
        return view('fe/login');
    }


    public function login(Request $request){
        $request->validate([
            'uname' => 'required',
            'password' => 'required',
        ]);
    
        $uname = $request->input('uname');
        $password = md5($request->input('password')); // Hash the provided password
    
        $solver = Solver::where('uname', $uname)
                        ->where('password', $password)
                        ->first();
    
        if($solver){
            $request->session()->put('uname', $uname);
            $request->session()->put('isLoggedIn', true);
            return redirect('/problems');
        } else {
            return redirect('/login')->with('error', 'Invalid username or password.');
        }
    }

    public function logout(Request $request){
        $request->session()->forget('uname');
        $request->session()->forget('isLoggedIn');
        return redirect('/');
    }
    
}
