<?php

namespace Tests\Unit\Documents\UseCases;

use PHPUnit\Framework\TestCase;
use App\Domains\Documents\UseCases\CreateDocumentUseCase;
use App\Domains\Documents\Repositories\DocumentRepositoryInterface;
use App\Domains\Documents\Services\DocumentSanitizer;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\DTO\DocumentResponseDTO;
use App\Domains\Documents\Entities\Document;
use Mockery;
use Mockery\MockInterface;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @covers \App\Domains\Documents\UseCases\CreateDocumentUseCase
 */
class CreateDocumentUseCaseTest extends MockeryTestCase
{

    public function test_document_title_already_exists_returns_error()
    {
        $dto = new DocumentDTO(
            userId: 1,
            title: 'test title',
            content: '<b>content</b>'
        );

        /** @var DocumentRepositoryInterface&MockInterface $repositoryMock */
        $repositoryMock = Mockery::mock(DocumentRepositoryInterface::class);
        $repositoryMock->shouldReceive('existsByTitle')->once()->with('test title', 1)->andReturn(true);

        /** @var DocumentSanitizer&MockInterface $sanitizeMock */
        $sanitizeMock = Mockery::mock(DocumentSanitizer::class);

        $useCase = new CreateDocumentUseCase($repositoryMock, $sanitizeMock);
        $result = $useCase->execute($dto);
        $this->assertFalse($result->success);
        $this->assertEquals('Document with this title already exists.', $result->message);
        $this->assertEquals(['available' => false], $result->extra);
    }
    public function testCreateDocument()
    {

        // 1. Создаем DTO с входными данными
        $dto = new DocumentDTO(
            userId: 1,
            title: 'test',
            content: '<b>content</b>'
        );
        // 2. Мокаем DocumentRepositoryInterface
        /** @var DocumentRepositoryInterface&MockInterface $repositoryMock */

        $repositoryMock = Mockery::mock(DocumentRepositoryInterface::class);
        $repositoryMock->shouldReceive('existsByTitle')->once()->with('test', 1)->andReturn(false);
        $repositoryMock->shouldReceive('save')->once()->withArgs(function (Document $document) use ($dto) {
            return $document->userId === $dto->userId && $document->title === $dto->title;
        })->andReturn(true);

        // 3. Мокаем DocumentSanitizer
        /** @var DocumentSanitizer&MockInterface $sanitizeMock */
        $sanitizeMock = Mockery::mock(DocumentSanitizer::class);
        $sanitizeMock->shouldReceive('sanitize')->once()->with($dto->content)->andReturn('<b>content</b>');

        // 4. Создаем экземпляр use case с моками
        $useCase = new CreateDocumentUseCase(
            documentRepository: $repositoryMock,
            documentSanitizer: $sanitizeMock
        );

        // 5. Выполняем Use Case
        $response = $useCase->execute($dto);

        // 6. Проверяем результат (тип, статус, сообщение)
        $this->assertInstanceOf(DocumentResponseDTO::class, $response);
        $this->assertTrue($response->success);
        $this->assertEquals('Document created successfully', $response->message);
        $this->assertInstanceOf(Document::class, $response->document);
    }

}
