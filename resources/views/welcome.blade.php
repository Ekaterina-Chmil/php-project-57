<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Менеджер задач</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">

    @include('layouts.navigation')

    <!-- Вывод флеш-сообщений -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @include('flash::message')
     </div>

    <!-- Основной контент страницы -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="max-w-3xl">
            <!-- Заголовок приветствия -->
            <h1 class="text-5xl font-medium tracking-tight text-gray-900 mb-6">
                Привет от Хекслета!
            </h1>
            <!-- Подзаголовок -->
            <p class="text-xl text-gray-500 mb-8">
                Это простой менеджер задач на Laravel
            </p>
            <!-- Интерактивная кнопка -->
            <button
                class="bg-white text-gray-700 font-medium px-5 py-2.5 border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">
                Нажми меня
            </button>
        </div>
    </main>

</body>

</html>
