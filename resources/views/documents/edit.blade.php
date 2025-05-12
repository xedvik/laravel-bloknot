@extends('layout')

@section('title', 'Редактировать документ')

@section('content')
    <h2>Редактировать документ</h2>

    <form method="POST" action="{{ route('documents.update', $document->id) }}">
        @csrf
        @method('PUT')

        <label>Заголовок</label>
        <input name="title" value="{{ old('title', $document->title) }}" required>

        <label>Контент (HTML допустим)</label>
        <textarea name="content" rows="10">{{ old('content', $document->content) }}</textarea>

        <button type="submit">Сохранить</button>
    </form>
@endsection
