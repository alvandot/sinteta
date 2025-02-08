<?php

namespace App\Services\Contracts;

interface AuthServiceInterface
{
    public function login(array $credentials): bool;
    public function logout(): void;
    public function register(array $userData): mixed;
    public function forgotPassword(string $email): void;
    public function resetPassword(array $data): bool;
    public function verifyEmail(string $token): bool;
    public function resendVerificationEmail(): void;
    public function getCurrentUser(): ?object;
}
