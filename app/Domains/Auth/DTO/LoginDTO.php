<?php
namespace App\Domains\Auth\DTO;

class LoginDTO {
    public function __construct(
        public string $email,
        public string $password
    )
    {}
}