<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Authentication\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * Login
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $result['user'] =  new UserResource(User::where('email', $request->email)->first());
            $result['type'] = 'Bearer';
            $result['token'] =  $result['user']->createToken('Galactic')->accessToken;

            return $this->successResponse($result, 'User login successfully', Response::HTTP_OK);
        } else {
            return $this->errorResponse(null, 'Invalid login credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
