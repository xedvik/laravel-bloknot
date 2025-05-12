<?php
namespace App\Domains\Auth\Entities;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password
    ) {}
}
