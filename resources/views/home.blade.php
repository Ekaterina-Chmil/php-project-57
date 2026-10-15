@extends('layouts.app')

@section('content')
    <!-- Основной контент страницы -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="max-w-3xl">
            <!-- Заголовок приветствия -->
            <h1 class="text-5xl font-medium tracking-tight text-gray-900 mb-6">
                {{ __('views.welcome.title') }}
            </h1>
            <!-- Подзаголовок -->
            <p class="text-xl text-gray-500 mb-8">
                {{ __('views.welcome.subtitle') }}
            </p>
            <!-- Интерактивная кнопка -->
            <button class="bg-white text-gray-700 font-medium px-5 py-2.5 border border-gray-300 rounded shadow-sm hover:bg-gray-50 transition">
                {{ __('views.welcome.button') }}
            </button>
        </div>
    </div>
@endsection
