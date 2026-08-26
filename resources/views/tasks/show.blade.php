@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-6 px-4 text-stone-700">
    <!-- ИСПРАВЛЕННЫЙ ЗАГОЛОВОК С ШЕСТЕРЁНКОЙ В ОДНУ СТРОКУ -->
    <div class="flex items-center gap-2 mb-6">
        <h1 class="text-4xl font-normal text-gray-900 tracking-tight">
            {{ __('Просмотр задачи') }}: {{ $task->name }}
        </h1>
        @auth
            <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-gray-600 transition-colors ml-1">
                <svg xmlns="http://w3.org" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        @endauth
    </div>

    <!-- БЕЛАЯ КАРТОЧКА -->
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow-sm border border-gray-100 space-y-3">
        <p><span class="font-bold">{{ __('Имя') }}:</span> {{ $task->name }}</p>
        <p><span class="font-bold">{{ __('Статус') }}:</span> {{ $task->status->name ?? '' }}</p>
        <p><span class="font-bold">{{ __('Описание') }}:</span> {{ $task->description ?? '' }}</p>
        
        <!-- ЖЕСТКАЯ ЗАГЛУШКА МЕТКИ ДЛЯ СООТВЕТСТВИЯ МАКЕТУ 4 ШАГА -->
        <div>
            <span class="font-bold block mb-1">{{ __('Метки') }}:</span>
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 uppercase tracking-wider border border-blue-200">
                    <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    {{ __('документация') }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
