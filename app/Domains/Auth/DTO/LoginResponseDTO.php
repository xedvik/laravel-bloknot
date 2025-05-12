<?php
namespace App\Domains\Auth\DTO;

use App\Domains\Auth\Entities\User;
use App\Infrastructure\Eloquent\Models\User as UserModel;
class LoginResponseDTO {
    public function __construct(
        public bool $success,
        public string $message,
        public ?User $user = null,
        public ?UserModel $userModel = null,
        public ?array $extra = null
    ) {}
}
