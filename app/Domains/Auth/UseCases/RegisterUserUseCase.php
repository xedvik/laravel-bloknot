<?php
namespace App\Domains\Auth\UseCases;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Entities\User;
use App\Domains\Auth\Factories\UserFactory;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
use App\Domains\Auth\DTO\RegisterResponseDTO;
class RegisterUserUseCase
{
    public function __construct(
       private UserRepositoryInterface $userRepository
    ) {
    }

    public function execute(RegisterDTO $dto):RegisterResponseDTO
    {
        $passwordHasher = new PasswordHasher;
        $user = UserFactory::createFromDTO($dto, $passwordHasher);
        $this->userRepository->create($user);
        $userModel = $this->userRepository->getModelById($user->id);
        return new RegisterResponseDTO(
            success: true,
            message: 'user created successfully',
            user: $user,
            userModel: $userModel
        );
    }
}