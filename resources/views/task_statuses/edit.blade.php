@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Заголовок --}}
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.statuses.edit') }}</h1>

        {{-- Карточка формы слева --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            {{-- Открываем форму Spatie, привязываем модель $taskStatus и метод PATCH --}}
            {{ html()->modelForm($taskStatus, 'PATCH', route('task_statuses.update', $taskStatus))->class('space-y-4')->novalidate()->open() }}

                {{-- Вставляем то же самое поле --}}
                @include('task_statuses._form')

                <!-- Кнопка обновления -->
                <div class="pt-4">
                    {{ html()->submit(__('views.buttons.update'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline') }}
                </div>

            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endsection
