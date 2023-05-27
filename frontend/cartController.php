<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class cartController extends Controller
{
   public function index()
    {
    	if(Auth::check())
    	{
    		return view('frontend.cart');	
    	}
    	return Redirect::to('login')->with('error','Direct Access denite');
    }
}
