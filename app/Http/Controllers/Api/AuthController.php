<?php

namespace App\Http\Controllers\Api;

use App\Traits\BaseResponse;
use App\Http\Requests\StoreUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use BaseResponse;

    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(StoreUserRequest $request)
    {
        $user = $this->authService->register($request->all());

        return $this->sendResponse($user, 'Registration Successfull.', 201);
    }

    public function login(Request $request)
    {
        $user = $this->authService->login($request->all());
        if( $user == 'false') {
           return response()->json(['success'=>false]); 
        }

        return $this->sendResponse($user, 'Login Successfull.', 201);
    }
}
