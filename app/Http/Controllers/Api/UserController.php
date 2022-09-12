<?php

namespace App\Http\Controllers\Api;

use App\Traits\BaseResponse;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use BaseResponse;

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService; 
    }

    public function index()
    {
        $users = $this->userService->all();
        if(!count($users) > 0){
            return $this->sendResponse($users, 'Record is Empty.'); 
        }
        return $this->sendResponse($users, 'Record retrieved successfully.');
    }

    public function find($id)
    {
        $user = $this->userService->find($id);
        if(!$user){
            return $this->sendError('User not Found.', [], 404); 
        }
        return $this->sendResponse($user,'User retrieved Successfully.');
    }

    public function update(UpdateUserRequest $request, $id)
    {   
        $user = $this->userService->update($request->all(), $id);
        if(!$user){
            return $this->sendError('User not Found.',[], 404); 
        }
        return $this->sendResponse($user,'User Updated Successfully.');
    }

    public function delete($id)
    {
        $user = $this->userService->destroy($id);
        if(!$user){
            return $this->sendError('User not Found.',[],404); 
        }
        return $this->sendResponse($user,'User Deleted successfully.');
    }
}