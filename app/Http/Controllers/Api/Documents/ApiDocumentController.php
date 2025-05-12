<?php

namespace App\Http\Controllers\Api\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\UseCases\CreateDocumentUseCase;
class ApiDocumentController extends Controller
{

    public function store(DocumentRequest $documentRequest, CreateDocumentUseCase $createDocument)
    {
        $dto = new DocumentDTO(
            userId: auth()->id(),
            title: $documentRequest->input('title'),
            content: $documentRequest->input('content')
        );
        $result = $createDocument->execute($dto);


            if (!$result->success) {
                return response()->json([
                    'status' => 'error',
                    'message' => $result->message,
                    'data' => $result->extra !== null ? ['available' => $result->extra['available']] : null,
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => $result->message,
                'data' => [
                    'user_id' => $result->document->userId,
                    'title' => $result->document->title,
                    'content' => $result->document->content
                ],
            ], 201);


    }


}