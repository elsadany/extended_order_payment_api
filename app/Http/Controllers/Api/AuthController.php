<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class AuthController extends Controller
{

  function __construct(private readonly UserService $user_service) {}

  //login function
  function login(LoginRequest $request)
  {
    $data = $this->user_service->login($request->getData());
    if (!$data) {
      return apiResponse()->respond(errors: ['Invalid credentials'], status: 401, errorCode: 'NF');
    }
    return apiResponse()->data(data: $data, message: 'login Successfully');
  }

  function register(RegisterRequest $request)
  {
    $data = $this->user_service->register($request->getData());
    return apiResponse()->data(data: $data, message: 'Registered Successfully');
  }
  
  function me(){
    $data = $this->user_service->me();

    return apiResponse()->data(data: $data, message: 'returned Successfully');

  }

  function logout(){
    $data = $this->user_service->logout();

    return apiResponse()->data(data: null, message: 'logged out Successfully');

  }
}
