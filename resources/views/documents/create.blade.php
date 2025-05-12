@extends('layout')

@section('title', 'Создать документ')

@section('content')
    <h2>Создать новый документ</h2>

    <form method="POST" action="{{ route('documents.store') }}">
        @csrf

        <label>Заголовок</label>
        <input name="title" value="{{ old('title') }}" required>

        <label>Контент (HTML допустим)</label>
        <textarea name="content" rows="10">{{ old('content') }}</textarea>

        <button type="submit">Создать</button>
    </form>
@endsection
