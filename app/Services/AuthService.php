<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use App\Traits\BaseResponse;

class AuthService extends Controller
{
    use BaseResponse;

    public function register($data)
    {
        try {

            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);

            $token['token'] =  $user->createToken('MyApp')->accessToken;
            $user = $user->toArray();
            $response = array_merge($token, $user);

            return $response;
        } catch (\Exception $e) {
            throw new HttpResponseException(
                $this->sendError('An Error Occured', ['error' => $e->getMessage()], 500)
            );
        }
    }

    public function login($data)
    {

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = Auth::user();
            $token['token'] =  $user->createToken('MyApp')->accessToken;
            $user = $user->toArray();
            $response = array_merge($token, $user);

            return $response;
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'incorrect email/password'], 401);
        }
    }
}
