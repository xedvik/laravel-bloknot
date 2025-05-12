<?php
namespace App\Domains\Documents\Factories;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\Entities\Document;
class DocumentFactory
{
    public static function createFromDTO(DocumentDTO $dto, string $cleanContent): Document
    {
        return new Document(
            id: 0,
            userId: $dto->userId,
            title: $dto->title,
            content: $cleanContent
        );
    }
}