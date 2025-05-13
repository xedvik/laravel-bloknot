<?php
namespace App\Domains\Auth\UseCases;
use App\Domains\Auth\DTO\LoginDTO;
use App\Domains\Auth\DTO\LoginResponseDTO;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
class LoginUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordHasher $passwordHasher
    ) {
    }

    public function execute(LoginDTO $dto):LoginResponseDTO
    {
        $user = $this->userRepository->findByEmail($dto->email);
        if(!$user || !$this->passwordHasher->verify($dto->password, $user->password)){
            return new LoginResponseDTO(
                success: false,
                message: 'invalid credentials'
            );
        }
        $userModel = $this->userRepository->getModelById($user->id);
        return new LoginResponseDTO(
            success: true,
            message: 'Login successful',
            user: $user,
            userModel: $userModel
        );
    }
}