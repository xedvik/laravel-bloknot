<?php
namespace App\Domains\Auth\UseCases;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Factories\UserFactoryInterface;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
use App\Domains\Auth\DTO\RegisterResponseDTO;
class RegisterUserUseCase
{
    public function __construct(
       private UserRepositoryInterface $userRepository,
       private UserFactoryInterface $userFactory,
       private PasswordHasher $passwordHasher
    ) {
    }

    public function execute(RegisterDTO $dto):RegisterResponseDTO
    {
        $user = $this->userFactory->createFromDTO($dto, $this->passwordHasher);
        $userModel = $this->userRepository->create($user);

        if (!$userModel) {
            return new RegisterResponseDTO(
                success: false,
                message: 'Failed to create user'
            );

        }

        return new RegisterResponseDTO(
            success: true,
            message: 'User created successfully',
            user: $user,
            userModel: $userModel
        );
    }
}