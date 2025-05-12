<?php
namespace App\Domains\Documents\Repositories;
use App\Domains\Documents\Entities\Document;
interface DocumentRepositoryInterface {
public function save(Document $document);
public function existsByTitle(string $title, int $userId): bool;

}