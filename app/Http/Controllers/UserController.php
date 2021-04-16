<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return Response::json($users,200,[],JSON_NUMERIC_CHECK);
    }
}
