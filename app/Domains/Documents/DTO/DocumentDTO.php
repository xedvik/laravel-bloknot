<?php
namespace App\Domains\Documents\DTO;

class DocumentDTO {
    public function __construct(
        public int $userId,
        public string $title,
        public string $content
    )
    {}
}