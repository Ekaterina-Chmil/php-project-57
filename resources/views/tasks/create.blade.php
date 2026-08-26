@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-6 px-4 text-stone-700">
    <!-- ЗАГОЛОВОК -->
    <h1 class="text-4xl font-normal text-gray-900 mb-6 tracking-tight">{{ __('Создать задачу') }}</h1>

    <!-- БЕЛАЯ КАРТОЧКА -->
    <div class="max-w-2xl bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('tasks.store') }}" class="space-y-4">
            @csrf

            <!-- Имя -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Имя') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm" required>
                @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Описание -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Описание') }}</label>
                <textarea name="description" id="description" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Статус -->
            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Статус') }}</label>
                <select name="status_id" id="status_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2" required>
                    <option value=""></option>
                    @foreach($statuses as $id => $name)
                        <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('status_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Исполнитель -->
            <div>
                <label for="assigned_to_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Исполнитель') }}</label>
                <select name="assigned_to_id" id="assigned_to_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value=""></option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ old('assigned_to_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('assigned_to_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- МЕТКИ -->
            <div>
                <label for="labels" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Метки') }}</label>
                <select name="labels[]" id="labels" multiple class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm h-32 p-2">
                    <option value="1">{{ __('ошибка') }}</option>
                    <option value="2">{{ __('документация') }}</option>
                    <option value="3">{{ __('дубликат') }}</option>
                    <option value="4">{{ __('доработка') }}</option>
                </select>
            </div>

            <!-- Кнопка -->
            <div class="pt-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm">
                    {{ __('Создать') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
