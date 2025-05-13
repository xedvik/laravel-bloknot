<?php

namespace Tests\Unit\Documents\UseCases;

use App\Domains\Auth\UseCases\LoginUserUseCase;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
use App\Domains\Auth\DTO\LoginDTO;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;
use Mockery;
use Mockery\MockInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @covers \App\Domains\Documents\UseCases\CreateDocumentUseCase
 */
class LoginUserUseCaseTest extends MockeryTestCase
{

    public function test_auth_with_error_email()
    {
        $dto = new LoginDTO(
            email: 'test@mail.ru',
            password: '1234567D'
        );
        $mockUser = new User(
            id: 1,
            name: 'test name',
            email: 'test@mail.ru',
            password: 'hashed_1234567D'
        );

        /** @var UserModel&MockInterface $eloquentUserMock */
        $eloquentUserMock = Mockery::mock(UserModel::class);

        /** @var UserRepositoryInterface&MockInterface $repositoryMock */
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('findByEmail')->once()->with($dto->email)->andReturn(null);

        /** @var PasswordHasher&MockInterface $passwordHasherMock */
        $passwordHasherMock = Mockery::mock(PasswordHasher::class);

        $useCase = new LoginUserUseCase($repositoryMock, $passwordHasherMock);
        $result = $useCase->execute($dto);

        $this->assertFalse($result->success);
        $this->assertEquals('invalid credentials', $result->message);
    }

    public function test_auth_with_error_password()
    {
        $dto = new LoginDTO(
            email: 'test@mail.ru',
            password: '1234567D'
        );
        $mockUser = new User(
            id: 1,
            name: 'test name',
            email: 'test@mail.ru',
            password: 'hashed_1234567D'
        );

        /** @var UserModel&MockInterface $eloquentUserMock */
        $eloquentUserMock = Mockery::mock(UserModel::class);

        /** @var UserRepositoryInterface&MockInterface $repositoryMock */
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('findByEmail')->once()->with($dto->email)->andReturn($mockUser);

        /** @var PasswordHasher&MockInterface $passwordHasherMock */
        $passwordHasherMock = Mockery::mock(PasswordHasher::class);
        $passwordHasherMock->shouldReceive('verify')->once()->with($dto->password, $mockUser->password)->andReturn(false);

        $useCase = new LoginUserUseCase($repositoryMock, $passwordHasherMock);
        $result = $useCase->execute($dto);

        $this->assertFalse($result->success);
        $this->assertEquals('invalid credentials', $result->message);
    }
    public function test_auth_success()
    {
        $dto = new LoginDTO(
            email: 'test@mail.ru',
            password: '1234567D'
        );
        $mockUser = new User(
            id: 1,
            name: 'test name',
            email: 'test@mail.ru',
            password: 'hashed_1234567D'
        );

        /** @var UserModel&MockInterface $eloquentUserMock */
        $eloquentUserMock = Mockery::mock(UserModel::class);

        /** @var UserRepositoryInterface&MockInterface $repositoryMock */
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('findByEmail')->once()->with($dto->email)->andReturn($mockUser);
        $repositoryMock->shouldReceive('getModelById')->once()->with($mockUser->id)->andReturn($eloquentUserMock);

        /** @var PasswordHasher&MockInterface $passwordHasherMock */
        $passwordHasherMock = Mockery::mock(PasswordHasher::class);
        $passwordHasherMock->shouldReceive('verify')->once()->with($dto->password, $mockUser->password)->andReturn(true);

        $useCase = new LoginUserUseCase($repositoryMock, $passwordHasherMock);
        $result = $useCase->execute($dto);

        $this->assertTrue($result->success);
        $this->assertEquals('Login successful', $result->message);
        $this->assertSame($eloquentUserMock, $result->userModel);
    }
}
