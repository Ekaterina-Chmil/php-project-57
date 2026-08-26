@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Большой заголовок --}}
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('Статусы') }}</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
            
            <!-- Кнопка "Создать статус" -->
            <div class="mb-4">
                <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    {{ __('Создать статус') }}
                </a>
            </div>

            <!-- Таблица статусов -->
            <table class="min-w-full divide-y divide-gray-200 text-sm text-stone-700">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ИМЯ') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ДАТА СОЗДАНИЯ') }}</th>
                        @auth <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('ДЕЙСТВИЯ') }}</th> @endauth
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($taskStatuses as $status)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-gray-500">{{ $status->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $status->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $status->created_at->format('d.m.Y') }}</td>
                            
                            @auth
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    {{-- Сначала Удалить, потом Изменить --}}
                                    <form action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Вы уверены?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">{{ __('Удалить') }}</button>
                                    </form>
                                    <a href="{{ route('task_statuses.edit', $status) }}" class="text-blue-600 hover:text-blue-900 ml-3 font-semibold">{{ __('Изменить') }}</a>
                                </td>
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 bg-gray-50">{{ __('Статусы не найдены') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
