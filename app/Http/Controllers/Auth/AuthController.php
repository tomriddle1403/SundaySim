<?php

namespace SundaySim\Http\Controllers\Auth;

use SundaySim\User;
use Validator;
use SundaySim\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AuthController extends Controller
{
  
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->redirectAfterLogout = 'auth/login';
        
        $this->redirectTo = 'backend/dashboard';
        
       //$this->middleware('guest', ['except' => 'getLogout']);
    }

  
}
