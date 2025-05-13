<?php
namespace App\Infrastructure\Eloquent\Factories;

use App\Domains\Auth\DTO\RegisterDTO;
use App\Domains\Auth\Entities\User;
use App\Domains\Auth\Factories\UserFactoryInterface;
use App\Domains\Auth\Services\PasswordHasher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Infrastructure\Eloquent\Models\User as UserModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Eloquent\Models\User>
 */
class UserFactory  extends Factory implements UserFactoryInterface
{
    protected $model = UserModel::class;
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
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