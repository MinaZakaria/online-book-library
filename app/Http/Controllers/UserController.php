<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;

use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function authenticate(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $response = $this->userService->authenticate($credentials);
        return response()->json(['data' => $response], 200);
    }

    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        $response = $this->userService->register($validatedData);

        return response()->json(['data' => $response], 200);
    }

    public function logout()
    {
        $this->userService->logout();
        return response()->json([], 204);
    }
}
