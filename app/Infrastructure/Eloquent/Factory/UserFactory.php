<?php
namespace App\Infrastructure\Eloquent\Factory;

use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Entities\User;
use App\Domains\Auth\Factories\UserFactoryInterface;
use App\Domains\Auth\Services\PasswordHasher;

class UserFactory implements UserFactoryInterface
{
    public function createFromDTO(RegisterDTO $dto, PasswordHasher $hasher): User
    {
        return new User(
            id: 0,
            name: $dto->name,
            email: $dto->email,
            password: $hasher->hash($dto->password)
        );
    }
}