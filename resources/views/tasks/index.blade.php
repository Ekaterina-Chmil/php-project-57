@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- 1. ЗАГОЛОВОК -->
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.tasks.index') }}</h1>

        <!-- БЛОК ФИЛЬТРАЦИИ СВЕРХУ -->
        <div class="w-full mb-6">
            <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap items-center gap-2 bg-transparent p-0 border-0">
                
                <!-- Статус -->
                <div class="w-48">
                    <select name="filter[status_id]" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm py-2">
                        <option value="">{{ __('views.attributes.status') }}</option>
                        @foreach($statuses as $id => $name)
                            <option value="{{ $id }}" {{ request()->input('filter.status_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Автор -->
                <div class="w-64">
                    <select name="filter[created_by_id]" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm py-2">
                        <option value="">{{ __('views.attributes.author') }}</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}" {{ request()->input('filter.created_by_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Исполнитель -->
                <div class="w-64">
                    <select name="filter[assigned_to_id]" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm py-2">
                        <option value="">{{ __('views.attributes.assigned_to') }}</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}" {{ request()->input('filter.assigned_to_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Кнопка Применить -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-medium transition whitespace-nowrap shadow-sm">
                    {{ __('views.buttons.apply') }}
                </button>

                <!-- Кнопка Создать задачу -->
                @auth
                    <div class="ml-auto">
                        <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm font-medium transition whitespace-nowrap block shadow-sm no-underline">
                            {{ __('views.tasks.create') }}
                        </a>
                    </div>
                @endauth
            </form>
        </div>

        <!-- ТАБЛИЦА -->
        <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-stone-700 table-fixed">
                <colgroup>
                    <col class="w-[6%]">   <!-- ID -->
                    <col class="w-[10%]">  <!-- СТАТУС -->
                    <col class="w-[20%]">  <!-- ИМЯ -->
                    <col class="w-[19%]">  <!-- АВТОР -->
                    <col class="w-[19%]">  <!-- ИСПОЛНИТЕЛЬ -->
                    <col class="w-[14%]">  <!-- ДАТА СОЗДАНИЯ -->
                    @auth <col class="w-[12%]"> @endauth <!-- ДЕЙСТВИЯ -->
                </colgroup>
                <thead class="bg-gray-50">
                    <tr class="text-gray-500 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">{{ __('views.attributes.status') }}</th>
                        <th class="px-6 py-3 text-left">{{ __('views.attributes.name') }}</th>
                        <th class="px-6 py-3 text-left">{{ __('views.attributes.author') }}</th>
                        <th class="px-6 py-3 text-left">{{ __('views.attributes.assigned_to') }}</th>
                        <th class="px-6 py-3 text-left">{{ __('views.attributes.date') }}</th>
                        @auth <th class="px-6 py-3 text-center">{{ __('views.attributes.actions') }}</th> @endauth
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-6 py-4 font-mono text-gray-400">{{ $task->id }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $task->status->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 text-blue-600 break-words font-medium">
                            <a href="{{ route('tasks.show', $task) }}" class="hover:underline">{{ $task->name }}</a>
                        </td>
                        <td class="px-6 py-4 truncate text-gray-600" title="{{ $task->creator->name ?? '' }}">
                            {{ $task->creator->name ?? '' }}
                        </td>
                        <td class="px-6 py-4 truncate text-gray-600" title="{{ $task->assignee->name ?? '—' }}">
                            {{ $task->assignee->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                            {{ $task->created_at->format('d.m.Y') }}
                        </td>
                        
                        @auth
                            <td class="px-6 py-4 text-center whitespace-nowrap text-xs">
                                <!-- Ссылка на изменение -->
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900 font-medium no-underline">{{ __('views.buttons.edit') }}</a>
                                
                                <!-- Кнопка удаления в один ряд, показывается только создателю -->
                                @if($task->created_by_id === auth()->id())
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('tasks.destroy', $task) }}" 
                                            onclick="event.preventDefault(); if(confirm('{{ __('Вы уверены?') }}')) { this.closest('form').submit(); }"
                                            class="text-red-600 hover:text-red-900 font-medium no-underline cursor-pointer">
                                                {{ __('views.buttons.delete') }}
                                            </a>
                                    </form>
                                @endif
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() ? 7 : 6 }}" class="py-8 px-4 text-center text-gray-400 bg-gray-50/50 italic">
                            {{ __('views.tasks.empty') }}
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
