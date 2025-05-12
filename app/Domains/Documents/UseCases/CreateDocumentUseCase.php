<?php
namespace App\Domains\Documents\UseCases;
use App\Domains\Documents\Repositories\DocumentRepositoryInterface;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\DTO\DocumentResponseDTO;
use App\Domains\Documents\Services\DocumentSanitizer;
use App\Domains\Documents\Factories\DocumentFactory;
class CreateDocumentUseCase
{
    public function __construct(
        private DocumentRepositoryInterface $documentRepository,
        private DocumentSanitizer $documentSanitizer,
    ) {
    }

    public function execute(DocumentDTO $documentDTO): DocumentResponseDTO
    {
        if($this->documentRepository->existsByTitle($documentDTO->title, $documentDTO->userId)){
            return new DocumentResponseDTO(
                success: false,
                message: 'Document with this title already exists.',
                extra: ['available' => false]
            );
        }
        $cleanHtml = $this->documentSanitizer->sanitize($documentDTO->content);
        $document = DocumentFactory::createFromDTO($documentDTO, $cleanHtml);
        $this->documentRepository->save($document);

        return new DocumentResponseDTO(
            success: true,
            message: 'Document created successfully',
            document: $document
        );
        // return $document;
    }
}