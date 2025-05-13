<?php

namespace Tests\Unit\Documents\UseCases;

use App\Domains\Auth\UseCases\RegisterUserUseCase;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\DTO\RegisterResponseDTO;
use App\Domains\Auth\Factories\UserFactoryInterface;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;
use Mockery;
use Mockery\MockInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @covers \App\Domains\Documents\UseCases\CreateDocumentUseCase
 */
class RegisterUserUseCaseTest extends MockeryTestCase
{

    public function test_register_success()
    {
        $dto = new RegisterDTO(
            name: 'test name',
            email: 'test@mail.ru',
            password: '1234567D'
        );
        $mockUser = new User(
            id: 1,
            name:'test name',
            email: 'test@mail.ru',
            password: 'hashed_1234567D'
        );

        /** @var PasswordHasher&MockInterface $passwordHasherMock */
        $passwordHasherMock = Mockery::mock(PasswordHasher::class);
        /** @var UserModel&MockInterface $eloquentUserMock */
        $eloquentUserMock = Mockery::mock(UserModel::class);

        /** @var UserFactoryInterface&MockInterface $userFactoryMock */
        $userFactoryMock = Mockery::mock(UserFactoryInterface::class);
        $userFactoryMock->shouldReceive('createFromDTO')->once()->with($dto,$passwordHasherMock)->andReturn($mockUser);

        /** @var UserRepositoryInterface&MockInterface $repositoryMock */
        $repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $repositoryMock->shouldReceive('create')->once()->with($mockUser)->andReturn($eloquentUserMock);

        $useCase = new RegisterUserUseCase($repositoryMock, $userFactoryMock,$passwordHasherMock);
        $result = $useCase->execute($dto);

        $this->assertTrue($result->success);
        $this->assertEquals('User created successfully', $result->message);
        $this->assertSame($mockUser, $result->user);
        $this->assertSame($eloquentUserMock, $result->userModel);

    }
}
