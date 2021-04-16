<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Enseignant;
use App\ClasseEnseignant;

class RegistrationController extends Controller
{


	private $enseignant = "";

    public function __construct(){

    }


    public function index()
    {        
        return view('auth.register');
    }

    public function register(Request $request){
    	$data=$request->all();
    	if(isset($data['level'])){
    		return $this->registerUsers($request);
    	}else{
    		return $this->registerTeachers($request);
    	}
    	
    }

    public function registerUsers(Request $request){
    	$validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->create($request->all());

        return view("auth.login");
    }

    public function registerTeachers(Request $request){
    	$validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $this->createTeacher($request->all());

        return view("auth.login");
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:2',
        ]);
    }


    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'department' => $data['department'],
            'level' => $data['level'],
            'class' => $data['class'],
            'password' => bcrypt($data['password']),
        ]);
        return $user;
    }

    protected function createTeacher(array $data)
    {
     
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'is_admin' => 1,
            'password' => bcrypt($data['password']),
        ]);


        $classe=$data['class'];

        foreach ($data['class'] as $select) {
            $this->createClassTeacher($select, $user);
        }

        return $user;
    }

    protected function createClassTeacher($code, $user)
    {
        $class = ClasseEnseignant::create([
            'Classe_code' => $code,
            'Enseignant_id' => $user->id
        ]);
        return $class;
    }

}
