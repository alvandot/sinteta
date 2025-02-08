<?php

namespace App\Services\Implementations;

use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthService implements AuthServiceInterface
{
    /**
     * Attempt to authenticate a user.
     *
     * @param array $credentials
     * @return bool
     * @throws ValidationException
     */
    public function login(array $credentials): bool
    {
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }


        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            return true;
        }

        return false;
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    /**
     * Register a new user.
     *
     * @param array $userData
     * @return mixed
     * @throws ValidationException
     */
    public function register(array $userData): mixed
    {
        $validator = Validator::make($userData, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ]);

        $user->assignRole($userData['role']);

        return $user;
    }

    /**
     * Send a password reset link to the user.
     *
     * @param string $email
     * @throws ValidationException
     */
    public function forgotPassword(string $email): void
    {
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        Password::sendResetLink(['email' => $email]);
    }

    /**
     * Reset the user's password.
     *
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function resetPassword(array $data): bool
    {
        $validator = Validator::make($data, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $status = Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        return $status === Password::PASSWORD_RESET;
    }

    /**
     * Verify the user's email address.
     *
     * @param string $token
     * @return bool
     */
    public function verifyEmail(string $token): bool
    {
        $user = Auth::user();
        if ($user && !$user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new \Illuminate\Auth\Events\Verified($user));
                return true;
            }
        }
        return false;
    }

    /**
     * Resend the email verification notification.
     *
     * @throws \Exception
     */
    public function resendVerificationEmail(): void
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        if ($user->hasVerifiedEmail()) {
            throw new \Exception('Email already verified');
        }

        $user->sendEmailVerificationNotification();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return object|null
     */
    public function getCurrentUser(): ?object
    {
        return auth()->user();
    }
}
