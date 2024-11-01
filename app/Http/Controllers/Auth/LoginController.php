<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request) 
    {
        $this->validate($request, [
            'email' => 'required|email|',
            'password' => 'required',
         ]);

         if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();
 
            return redirect()->route('dashboard');
        }
 
        // return back()->withErrors([
        //     'login' => 'The provided credentials do not match our records.',
        // ])->onlyInput('login');

        return back()->with('status', 'Invalid login details');
    }
}
