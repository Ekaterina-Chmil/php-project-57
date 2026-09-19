@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Заголовок --}}
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('Метки') }}</h1>

        {{-- Кнопка создания --}}
        @auth
            <div class="mb-6">
                <a href="{{ route('labels.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-medium transition no-underline inline-block">
                    {{ __('Создать метку') }}
                </a>
            </div>
        @endauth

        {{-- Контейнер таблицы --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-stone-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">ID</th>
                        <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">{{ __('Имя') }}</th>
                        <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">{{ __('Описание') }}</th>
                        <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">{{ __('Дата создания') }}</th>
                        @auth
                            <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">{{ __('Действия') }}</th>
                        @endauth
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($labels as $label)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $label->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $label->name }}</td>
                            <td class="px-6 py-4 text-xs">{{ $label->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs">{{ $label->created_at->format('d.m.Y') }}</td>
                            @auth
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('labels.destroy', $label) }}" 
                                           onclick="event.preventDefault(); if(confirm('{{ __('Вы уверены?') }}')) { this.closest('form').submit(); }"
                                           class="text-red-600 hover:text-red-900 font-medium no-underline cursor-pointer mr-3">
                                            {{ __('Удалить') }}
                                        </a>
                                    </form>
                                    <a href="{{ route('labels.edit', $label) }}" class="text-blue-600 hover:text-blue-900 font-medium no-underline">{{ __('Изменить') }}</a>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
