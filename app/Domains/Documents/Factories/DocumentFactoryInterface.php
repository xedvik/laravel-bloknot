<?php
namespace App\Domains\Documents\Factories;

use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\Entities\Document;

interface DocumentFactoryInterface
{
    public static function createFromDTO(DocumentDTO $dto, string $cleanContent): Document;
    public function definition(): array;
}
