<!-- Шапка сайта (Навигационная панель) -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Левая сторона: Логотип/Название и Меню по центру -->
            <div class="flex items-center justify-between flex-1 mr-10">
                <a href="/" class="text-xl font-bold tracking-tight text-gray-900 no-underline">
                    Менеджер задач
                </a>
                <nav class="flex space-x-6 text-sm font-medium mx-auto">
                    <a href="{{ route('tasks.index') }}" 
                        class="{{ request()->routeIs('tasks.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-900' }} pb-1 transition no-underline">
                        Задачи
                    </a>
                    <a href="{{ route('task_statuses.index') }}" 
                       class="{{ request()->routeIs('task_statuses.*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-900' }} pb-1 transition no-underline">
                        Статусы
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 transition no-underline">Метки</a>
                </nav>
            </div>

            <!-- Правая сторона: Кнопки Входа/Регистрации/Выхода -->
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
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-medium hover:bg-blue-700 transition no-underline">
                            Вход
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-medium hover:bg-blue-700 transition no-underline">
                                Регистрация
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</header>
