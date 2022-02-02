<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

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

        $data = $this->userService->authenticate($credentials);
        return response()->json(['data' => $data], 200);
    }

    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        $data = $this->userService->register($validatedData);

        return response()->json(['data' => $data], 200);
    }

    public function logout()
    {
        $this->userService->logout();
        return response()->json([], 204);
    }
}
