<?php

namespace App\Http\Controllers\Web\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Domains\Documents\DTO\DocumentDTO;
use App\Domains\Documents\UseCases\CreateDocumentUseCase;
class WebDocumentController extends Controller
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
            userId: auth()->id(),
            title: $documentRequest->input('title'),
            content: $documentRequest->input('content')
        );
        $result = $createDocument->execute($dto);


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