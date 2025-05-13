<?php
namespace App\Domains\Auth\Factories;

use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Entities\User;
use App\Domains\Auth\Services\PasswordHasher;

interface UserFactoryInterface
{
    public function createFromDTO(RegisterDTO $dto, PasswordHasher $hasher): User;
    public function definition(): array;
    public function unverified(): static;
}
