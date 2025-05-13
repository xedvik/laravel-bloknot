<?php
namespace App\Infrastructure\Eloquent\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\Entities\Document;
use App\Infrastructure\Eloquent\Models\Document as DocumentModel;
use App\Domains\Documents\Factories\DocumentFactoryInterface;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Eloquent\Models\Document>
 */
class DocumentFactory extends Factory implements DocumentFactoryInterface
{
    protected $model = DocumentModel::class;
    public static function createFromDTO(DocumentDTO $dto, string $cleanContent): Document
    {
        return new Document(
            id: 0,
            userId: $dto->userId,
            title: $dto->title,
            content: $cleanContent
        );
    }



    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}