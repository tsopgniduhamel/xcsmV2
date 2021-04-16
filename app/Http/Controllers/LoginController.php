<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enseignant;

class LoginController extends Controller
{
    public function __construct(){
    	$this->middleware('guest')->except('logout');
    }

    public function index(){
    	return view('auth.login');
    }



    public function login(Request $request){
    	
    	$email=$request->input('email');
    	$password=bcrypt($request->input('password'));

    	$ens=Enseignant::where('email', $email)->get();

    	if(strcmp($ens->password, $password)==0){
    		return view('dashboard');
    	}else{

    		$errors = [$email => trans('auth.failed')];
	        
	        if ($request->expectsJson()) {
	            return response()->json($errors, 422);
	        }else{
	        	return response()->json($errors, 422);
	        }

    	}

    }

}
