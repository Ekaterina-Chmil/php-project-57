<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Менеджер задач') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Подключаем наше меню навигации -->
            @include('layouts.navigation')

            <!-- Вывод флеш-сообщений -->
            @if (session()->has('flash_notification'))
                @foreach (collect(session('flash_notification'))->all() as $message)
                    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8"><div role="alert" class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg border border-green-200">{{ trim(is_array($message) ? $message['message'] : $message->message) }}</div></div>
                @endforeach
            @endif

            <!-- Главный контент страницы -->
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>

