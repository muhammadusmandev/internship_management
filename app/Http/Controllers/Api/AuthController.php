<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\{User, RoleUser};
use Hash;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * register user with any role.
     *
     * @return \Illuminate\Http\Request
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated->name,
                'email' => $validated->email,
                'password' => Hash::make($validated->password)
            ]);

            $role_user = RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $validated->role_id
            ]);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $validated->role_id,
                'tokenType' => 'Bearer',
                'token' => $user->createToken('token')->plainTextToken
            ];

            return $this->successResponse($data, 'User register successfully!');
        } catch(\Exception $e){
            $errors = [
                'error' => $e->getMessage()
            ];

            return $this->errorResponse($errors, 'Something went wrong!');
        }
    }

    /**
     * login user with any role.
     *
     * @return \Illuminate\Http\Request
     */
    public function login(Request $request): JsonResponse
    {
        try{
            return $this->successResponse($data, 'User login successfully!');
        } catch(\Exception $e){
            $errors = [
                'error' => $e->getMessage()
            ];

            return $this->errorResponse($errors, 'Something went wrong!');
        }
    }

    /**
     * logout user with any role.
     *
     * @return \Illuminate\Http\Request
     */
    public function logout(Request $request): JsonResponse
    {
        
    }
}
