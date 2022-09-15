<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\BaseResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{   
    use  BaseResponse;

    public function changePassword(Request $request) {
        
        $user = User::find($request->id);
        
        if(!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success'=>false, "message"=>"Invalid Old Pasword"]); 
        }
        $data = $user->update(['password'=> Hash::make($request->new_password)]);

        if ($data == false) {
            return $this->sendError('Record not found.',[],500);
        }
        $user->tokens->each(function($token, $key){
            $token->delete();
        });
        $token = $user->createToken('MyApp')->accessToken;
        return $this->sendResponse($token, 'Password Changed successfully.');
       
    }

}
