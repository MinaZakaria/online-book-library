<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(array $credentials)
    {
        $token = Auth::attempt($credentials);
        if (!$token) {
            throw new AuthenticationException();
        }

        $user = Auth::user();

        return ['user' => $user, 'token' => $token];
    }

    public function register(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        $user = $this->userRepository->create($userData);

        $token = JWTAuth::fromUser($user);
        return ['user' => $user, 'token' => $token];
    }

    public function logout()
    {
        Auth::logout();
    }
}
