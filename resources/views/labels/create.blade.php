@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('Создать метку') }}</h1>

        {{-- Карточка формы --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            <form method="POST" action="{{ route('labels.store') }}" class="space-y-4" novalidate>
                @csrf

            <!-- Имя метки -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Имя') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm" required>
                @error('name')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Описание метки -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Описание') }}</label>
                <textarea name="description" id="description" rows="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
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
</div>
@endsection
