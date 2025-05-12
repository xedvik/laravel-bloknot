@extends('layout')

@section('title', $document->title)

@section('content')
    <h2>{{ $document->title }}</h2>

    <div>{!! $document->content !!}</div>

    <a href="{{ route('documents.edit', $document->id) }}">Редактировать</a>
    <form method="POST" action="{{ route('documents.destroy', $document->id) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Удалить</button>
    </form>
@endsection
