<?php
namespace App\Domains\Documents\DTO;

use App\Domains\Documents\Entities\Document;

class DocumentResponseDTO {
    public function __construct(
        public bool $success,
        public string $message,
        public ?Document $document = null,
        public ?array $extra = null
    ) {}
}
