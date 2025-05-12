<?php
namespace App\Domains\Documents\Entities;

class Document {

    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public string $content
    ){}

}