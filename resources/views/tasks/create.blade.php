@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- ЗАГОЛОВОК -->
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.tasks.create') }}</h1>

        <!-- БЕЛАЯ КАРТОЧКА СЛЕВА -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            {{-- Открываем форму Spatie для создания --}}
            {{ html()->form('POST', route('tasks.store'))->attribute('novalidate', 'novalidate')->class('space-y-4')->open() }}


                {{-- Подключаем общий подшаблон со всеми инпутами --}}
                @include('tasks._form')

                <!-- Кнопка -->
                <div class="pt-2">
                    {{ html()->submit(__('views.buttons.create'))->class('bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm') }}
                </div>

            {{-- Закрываем форму --}}
            {{ html()->form()->close() }}
        </div>
    </div>
</div>
</div>
@endsection
