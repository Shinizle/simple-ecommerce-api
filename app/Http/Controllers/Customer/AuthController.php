<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\FailedLoginException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\CustomerRegisterRequest;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function register(CustomerRegisterRequest $request)
    {
        $user = $this->createNewUser($request);
        $token = $user->createToken('userToken')->accessToken;

        return response()->json(['token' => $token, 'user' => new UserResource($user)], self::SUCCESS_STATUS);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('userToken')->accessToken;

            return response()->json(['token' => $token, 'user' => new UserResource($user)], self::SUCCESS_STATUS);
        } else {
            throw new FailedLoginException();
        }
    }

    private function createNewUser($data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password)
        ]);
        $user->assignRole(User::CUSTOMER);

        return $user;
    }
}
