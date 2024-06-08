<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{RegisterRequest, LoginRequest};
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\{User, RoleUser};
use Auth;
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
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            $role_user = RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $validated['role_id']
            ]);

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $validated['role_id'],
                'tokenType' => 'Bearer',
                'token' => $user->createToken('token')->plainTextToken
            ];

            return $this->successResponse($data, 'User register successfully!');
        } catch(\Exception $e){
            $errors = [
                'error' => $e->getMessage()
            ];

            return $this->errorResponse($errors, 'Something went wrong!', 500);
        }
    }

    /**
     * login user with any role.
     *
     * @return \Illuminate\Http\Request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try{
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();
            
            if ($user) {
                if(Hash::check($validated['password'], $user->password)){
                    $data = [
                        'name' => $user->name,
                        'email' => $user->email,
                        'tokenType' => 'Bearer',
                        'token' => $user->createToken('token')->plainTextToken
                    ];

                    return $this->successResponse($data, 'User login successfully!');
                }
            }


            $errors = ['error' => 'Your credentials are wrong!'];
            return $this->errorResponse($errors, 'Something went wrong!' , 401);

        } catch(\Exception $e){
            $errors = ['error' => $e->getMessage()];

            return $this->errorResponse($errors, 'Something went wrong!', 500);
        }
    }

    /**
     * logout user with any role.
     *
     * @return \Illuminate\Http\Request
     */
    public function logout(): JsonResponse
    {
        try{
            Auth::user()->currentAccessToken()->delete();;

            return $this->successResponse([], 'User logout successfully!');
                

        } catch(\Exception $e){
            $errors = ['error' => $e->getMessage()];

            return $this->errorResponse($errors, 'Something went wrong!', 500);
        }
    }
}
