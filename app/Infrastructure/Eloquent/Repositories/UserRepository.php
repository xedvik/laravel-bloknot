<?php
namespace App\Infrastructure\Eloquent\Repositories;

use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;

class UserRepository implements UserRepositoryInterface {

    public function create(User $user): UserModel
    {
        $eloquentUser = UserModel::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);
        $user->id = $eloquentUser->id;
        return $eloquentUser;
    }

    public function getModelById($id): UserModel|null
    {
        return UserModel::find($id);
    }

    public function findByEmail($email): ?User
    {
        $model = UserModel::where('email', $email)->first();
        if(!$model) return null;
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password
        );
    }
}
