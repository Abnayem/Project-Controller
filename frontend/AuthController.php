<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
class AuthController extends Controller
{
    public function index()
    {
    	return view('frontend.login');
    }

    public function register()
    {
    	return view('frontend.register');
    }
    public function create(array $data )

    {
        User::create([
        'name'=>$data['name'],
        'email'=>$data['email'],
        'password'=>Hash::make($data['password']),
          ]);
    }

   public function post_register(Request $request)
    {
    	request()->validate([

    		'name'=>'required',
    		'email'=>'required|email|unique:users',
    		'password'=>'required|min:6',


    	]);

    	$data = $request->all();
    	$check = $this->create($data);
    	return Redirect::to('login');



    }

    public function post_login(Request $request)
    {
    	request()->validate([
    		'email'=>'required',
    		'password'=>'required|min:6',
    	]);
    	$cridantial = $request->only('email','password');
    	if(Auth::attempt($cridantial))
    	{
    		return Redirect::to('/');
    	}
    	else
    	{
    		return Redirect::to('login')->with('status','Your Email and password Unvalid');
    	}
    }

    public function dashboard()
    {
    	if(Auth::check())
    	{
    		return view('frontend.dashboard');	
    	}
    	return Redirect::to('login')->with('error','Direct Access denite');
    }

    public function logout()
    {
    	Session::flush();
    	Auth::logout();
    	return Redirect::to('/');
    }
}
