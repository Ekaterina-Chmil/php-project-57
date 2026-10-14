@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- ЗАГОЛОВОК -->
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.tasks.edit') }}</h1>

        <!-- БЕЛАЯ КАРТОЧКА СЛЕВА -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-4" novalidate>
                @csrf
                @method('PATCH')

            <!-- Имя -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('views.attributes.name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm" required>
                @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Описание -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('views.attributes.description') }}</label>
                <textarea name="description" id="description" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm">{{ old('description', $task->description) }}</textarea>
                @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Статус -->
            <div>
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('views.attributes.status') }}</label>
                <select name="status_id" id="status_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2" required>
                    <option value=""></option>
                    @foreach($statuses as $id => $name)
                        <option value="{{ $id }}" {{ old('status_id', $task->status_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('status_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Исполнитель -->
            <div>
                <label for="assigned_to_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('views.attributes.assigned_to') }}</label>
                <select name="assigned_to_id" id="assigned_to_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2">
                    <option value=""></option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}" {{ old('assigned_to_id', $task->assigned_to_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('assigned_to_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- МЕТКИ -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">{{ __('views.attributes.labels') }}</label>
                <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded border border-gray-200">
                    @foreach($labels as $id => $name)
                        <div class="flex items-center">
                            <input type="checkbox" name="labels[]" value="{{ $id }}" id="label_{{ $id }}"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                {{ in_array($id, old('labels', $task->labels->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label for="label_{{ $id }}" class="ml-2 text-sm text-gray-600">{{ $name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>


            <!-- Кнопка -->
            <div class="pt-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm">
                    {{ __('views.buttons.update') }}
                </button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection
