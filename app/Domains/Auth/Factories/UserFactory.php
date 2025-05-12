<?php
namespace App\Domains\Auth\Factories;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Entities\User;
use App\Domains\Auth\Services\PasswordHasher;


class UserFactory
{
    public static function createFromDTO(RegisterDTO $dto, PasswordHasher $passwordHasher): User
    {
        return new User(
            id: 0,
            name: $dto->name,
            email: $dto->email,
            password: $passwordHasher->hash($dto->password)

        );
    }
}