@extends('layouts.app')

@section('content')
<div class="grid col-span-full max-w-2xl text-stone-700 bg-white p-6 rounded-lg shadow-md mx-auto my-6">
    <h1 class="text-3xl font-bold mb-6">{{ __('Создать статус') }}</h1>

    <form method="POST" action="{{ route('task_statuses.store') }}" class="space-y-4">
        @csrf

        <!-- Имя статуса -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Имя') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full" required>
            @error('name')
                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <!-- Кнопка отправки -->
        <div class="pt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                {{ __('Создать') }}
            </button>
        </div>
    </form>
</div>
@endsection
