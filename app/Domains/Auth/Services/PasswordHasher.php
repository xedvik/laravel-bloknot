<?php
namespace App\Domains\Auth\Services;

class PasswordHasher
{
    public function hash(string $password): string
    {
        return bcrypt($password);
    }

    public function verify(string $plain, string $hash): bool
    {
        return password_verify($plain, $hash);
    }
}