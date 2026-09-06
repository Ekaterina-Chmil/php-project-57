@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-6 px-4 text-stone-700">
    <!-- 1. ЗАГОЛОВОК -->
    <h1 class="text-4xl font-semibold text-gray-900 mb-6 tracking-tight">{{ __('Задачи') }}</h1>

    <!-- БЛОК ФИЛЬТРАЦИИ СВЕРХУ -->
    <div class="w-full mb-6">
        <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap items-center gap-2 bg-transparent p-0 border-0">
            
            <!-- Статус -->
            <div class="w-40">
                <select name="filter[status_id]" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value="">{{ __('Статус') }}</option>
                    @foreach($statuses as $id => $name)
                        <option value="{{ $id }}" {{ request()->input('filter.status_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Автор -->
            <div class="w-40">
                <select name="filter[created_by_id]" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value="">{{ __('Автор') }}</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ request()->input('filter.created_by_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Исполнитель -->
            <div class="w-40">
                <select name="filter[assigned_to_id]" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value="">{{ __('Исполнитель') }}</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ request()->input('filter.assigned_to_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Метки -->
            <div class="w-40">
                <select name="filter[labels]" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value="">{{ __('Метки') }}</option>
                    @foreach($labels as $id => $name)
                        <option value="{{ $id }}" {{ request()->input('filter.labels') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Кнопка Применить -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm whitespace-nowrap shadow-sm">
                {{ __('Применить') }}
            </button>

            <!-- Кнопка Создать задачу -->
            @auth
                <div class="ml-auto">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm whitespace-nowrap block shadow-sm">
                        {{ __('Создать задачу') }}
                    </a>
                </div>
            @endauth
        </form>
    </div>

    <!-- ТАБЛИЦА -->
    <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm mt-4">
        <table class="w-full text-left border-collapse table-fixed">
            <colgroup>
                <col class="w-[6%]">   <!-- ID -->
                <col class="w-[10%]">  <!-- СТАТУС -->
                <col class="w-[20%]">  <!-- ИМЯ -->
                <col class="w-[19%]">  <!-- АВТОР -->
                <col class="w-[19%]">  <!-- ИСПОЛНИТЕЛЬ -->
                <col class="w-[14%]">  <!-- ДАТА СОЗДАНИЯ -->
                @auth <col class="w-[12%]"> @endauth <!-- ДЕЙСТВИЯ -->
            </colgroup>
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">{{ __('СТАТУС') }}</th>
                    <th class="py-3 px-4">{{ __('ИМЯ') }}</th>
                    <th class="py-3 px-4">{{ __('АВТОР') }}</th>
                    <th class="py-3 px-4">{{ __('ИСПОЛНИТЕЛЬ') }}</th>
                    <th class="py-3 px-4">{{ __('ДАТА СОЗДАНИЯ') }}</th>
                    @auth <th class="py-3 px-4 text-center">{{ __('ДЕЙСТВИЯ') }}</th> @endauth
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-3 px-4 font-mono text-gray-400">{{ $task->id }}</td>
                        <td class="py-3 px-4 text-gray-600">
                            {{ $task->status->name ?? '' }}
                        </td>
                        <td class="py-3 px-4 text-blue-600 break-words font-medium">
                            <a href="{{ route('tasks.show', $task) }}" class="hover:underline">{{ $task->name }}</a>
                        </td>
                        <td class="py-3 px-4 truncate text-gray-600" title="{{ $task->creator->name ?? '' }}">
                            {{ $task->creator->name ?? '' }}
                        </td>
                        <td class="py-3 px-4 truncate text-gray-600" title="{{ $task->assignee->name ?? '—' }}">
                            {{ $task->assignee->name ?? '—' }}
                        </td>
                        <td class="py-3 px-4 text-gray-500 whitespace-nowrap">
                            {{ $task->created_at->format('d.m.Y') }}
                        </td>
                        
                        @auth
                            <td class="py-3 px-4 text-center whitespace-nowrap text-xs">
                                <!-- Ссылка на изменение -->
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900 font-medium no-underline">{{ __('Изменить') }}</a>
                                
                                <!-- Кнопка удаления в один ряд, показывается только создателю -->
                                @if($task->created_by_id === auth()->id())
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('{{ __('Вы уверены?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium bg-transparent p-0 border-0 cursor-pointer">
                                            {{ __('Удалить') }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() ? 7 : 6 }}" class="py-8 px-4 text-center text-gray-400 bg-gray-50/50 italic">
                            {{ __('Нет добавленных задач') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ПАГИНАЦИЯ -->
    <div class="mt-4">
        {{ $tasks->links() }}
    </div>
</div>
@endsection
