@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.statuses.create') }}</h1>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            {{-- Открываем форму Spatie для создания статуса --}}
            {{ html()->form('POST', route('task_statuses.store'))->attribute('novalidate', 'novalidate')->class('space-y-4') }}

                {{-- Вставляем поле имени --}}
                @include('task_statuses._form')

                <!-- Кнопка отправки -->
                <div class="pt-4">
                    {{ html()->submit(__('views.buttons.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline') }}
                </div>

            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endsection
