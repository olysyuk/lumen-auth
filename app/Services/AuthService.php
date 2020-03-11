<?php

namespace App\Services;

use JWTAuth;
use Laravel\Lumen\Application;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register(string $email, string $password)
    {
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'activation_code' => md5($email . uniqid('', true))
        ]);

        $this->sendActivationEmail($user);

        return $user;
    }

    public function sendActivationEmail(User $user)
    {
        // TODO implement queue
    }

    /**
     * Login user and get token
     * @return Token or null
     */
    public function login(string $email, string $password): ?string
    {
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return JWTAuth::fromUser($user);
        }

        return null;
    }

    public function activate(string $code)
    {
        ValidationException::withMessages(['Incorrect activation code']);
    }

    public function authenticate(string $token): ?User
    {
        return JWTAuth::parseToken()->authenticate();
    }
}
