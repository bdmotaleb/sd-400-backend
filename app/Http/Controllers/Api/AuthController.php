<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            "email"    => "required|email",
            "password" => "required"
        ]);

        # Check validation
        if ($validator->fails()) return validation_error($validator->errors());

        # Login check
        if (Auth::attempt($credentials)) {
            $user          = Auth::user();
            $data['name']  = $user->name;
            $data['token'] = $user->createToken('tokenName')->accessToken;

            return success_response($data, 'Login success');
        } else {
            return error_response(__('auth.failed'), 401);
        }
    }

    public function logout()
    {
        auth()->user()->token()->revoke();

        return success_response([], 'Logout success');
    }

    public function register()
    {

    }

    public function getUser()
    {
        return success_response(auth()->user());
    }
}
