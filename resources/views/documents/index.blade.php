@extends('layout')

@section('title', 'Мои документы')

@section('content')
    <h2>Мои документы</h2>

    {{-- @foreach ($documents as $document)
        <div>
            <a href="{{ route('documents.show', $document->id) }}">
                {{ $document->title }}
            </a>
            <small>обновлён {{ $document->updated_at->diffForHumans() }}</small>
        </div>
    @endforeach --}}
@endsection
