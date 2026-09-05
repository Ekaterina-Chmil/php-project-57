@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-6 px-4 text-stone-700">
    <h1 class="text-4xl font-normal text-gray-900 mb-6 tracking-tight">{{ __('Изменение метки') }}</h1>

    <div class="max-w-2xl bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <form method="POST" action="{{ route('labels.update', $label) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Имя метки -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Имя') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name', $label->name) }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm" required>
                @error('name')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Описание метки -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Описание') }}</label>
                <textarea name="description" id="description" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm">{{ old('description', $label->description) }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Кнопка -->
            <div class="pt-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm">
                    {{ __('Обновить') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
