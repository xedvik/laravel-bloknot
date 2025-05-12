<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Документы')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Документ-сервис</h1>
        <nav>
            <a href="{{ route('main') }}">Мои документы</a> |
            <a href="{{ route('document.create') }}">Создать</a> |
            {{-- <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Выйти</button>
            </form> --}}
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
