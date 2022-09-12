<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Traits\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserService
{
    use BaseResponse;

    public function all()
    {
        $users = User::orderBy('name','ASC')->get();
        return UserResource::collection($users);
        
    }

    public function update($data, $id)
    {   
        try{
            $user = User::find($id);
            if (is_null($user)) {
                return false;
            }
            $user->update($data);

            return new UserResource($user);

        } catch (\Exception $e) {
            
            throw new HttpResponseException(
                $this->sendError('An Error Occured', ['error'=>$e->getMessage()],500)
            );
        }
    }

    public function find($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return false;
        }
        
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return false;
        }
        $data = $user->delete();

        return $data;
    }
}