<?php
namespace App\Domains\Auth\Repositories;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;

interface UserRepositoryInterface {
    public function create(User $user): UserModel;
    public function findByEmail($email): ?User;

    public function getModelById($id): ?UserModel;
}
