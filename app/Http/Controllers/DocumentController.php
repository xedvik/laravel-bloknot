<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\UseCases\CreateDocumentUseCase;

class DocumentController extends Controller
{

    public function index()
    {
        return view('documents.index');
    }

    public function create()
    {
        return view('documents.create');
    }
    public function store(DocumentRequest $documentRequest, CreateDocumentUseCase $createDocument)
    {
        $dto = new DocumentDTO(
            userId: '1',//$documentRequest-> //auth()->id,
            title: $documentRequest->input('title'),
            content: $documentRequest->input('content')
        );
        $result = $createDocument->execute($dto);

        //Если API запрос
        if ($documentRequest->wantsJson()) {
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
        //Если веб запрос
        if (!$result->success) {
            return redirect()->back()->withErrors($result->message);
        }
        return redirect()->route('main');
    }

    public function edit()
    {
        return view('documents.edit');
    }

    public function update()
    {

    }

    public function show()
    {
        return view('documents.show');
    }
    public function destroy()
    {

    }
}