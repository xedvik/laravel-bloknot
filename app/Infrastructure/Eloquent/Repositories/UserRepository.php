<?php
namespace App\Infrastructure\Eloquent\Repositories;

use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as EloquentUser;
class UserRepository implements UserRepositoryInterface {

    public function create(User $user)
    {
        $eloquentUser = EloquentUser::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);
        $user->id = $eloquentUser->id;
    }
    public function getModelById($id): EloquentUser|null
    {
        return EloquentUser::findOrFail($id)->first();
    }
    public function findByEmail($email): ?User
    {
        $model = EloquentUser::where('email', $email)->first();
        if(!$model) return null;
        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            password: $model->password
        );
    }
}