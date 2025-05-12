<?php
namespace App\Domains\Auth\Repositories;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;
interface UserRepositoryInterface {
    public function create(User $user);
    public function findByEmail($email): ?User;

    public function getModelById($id): ?UserModel;
}