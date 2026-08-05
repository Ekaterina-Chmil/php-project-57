<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Менеджер задач</title>

    <!-- Подключение стилей проекта (Tailwind CSS) -->
    <script src="https://tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <!-- Шапка сайта (Навигационная панель) -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Левая сторона: Логотип/Название и Меню по центру -->
                <div class="flex items-center justify-between flex-1 mr-10">
                    <a href="/" class="text-xl font-bold tracking-tight text-gray-900">
                        Менеджер задач
                    </a>
                    <nav class="flex space-x-6 text-sm font-medium text-gray-500 mx-auto">
                        <a href="#" class="hover:text-gray-900 transition">Задачи</a>
                        <a href="#" class="hover:text-gray-900 transition">Статусы</a>
                        <a href="#" class="hover:text-gray-900 transition">Метки</a>
                    </nav>
                </div>

                <!-- Правая сторона: Кнопки Входа/Регистрации -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <!-- Пользователь залогинен: показываем синюю кнопку Выход -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-medium hover:bg-blue-700 transition">
                                    Выход
                                </button>
                            </form>
                        @else
                            <!-- Гость: показываем Вход и Регистрацию -->
                            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-medium hover:bg-blue-700 transition">
                                Вход
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-medium hover:bg-blue-700 transition">
                                    Регистрация
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>
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
