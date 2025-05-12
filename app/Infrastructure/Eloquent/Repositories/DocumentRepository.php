<?php
namespace App\Infrastructure\Eloquent\Repositories;

use App\Domains\Documents\Repositories\DocumentRepositoryInterface;
use App\Domains\Documents\Entities\Document;
use App\Infrastructure\Eloquent\Models\Document as EloquentDocument;
class DocumentRepository implements DocumentRepositoryInterface {

    public function save(Document $document)
    {
        $eloquentDocument = EloquentDocument::create([
            'user_id' => $document->userId,
            'title' => $document->title,
            'content' => $document->content
        ]);
        $document->id = $eloquentDocument->id;
    }

    public function existsByTitle(string $title, int $userId): bool
    {
        return EloquentDocument::where('title', $title)->where('user_id', $userId)->exists();
    }
}