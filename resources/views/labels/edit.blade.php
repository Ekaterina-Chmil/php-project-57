@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Заголовок --}}
        <h1 class="text-4xl font-bold mb-6 text-stone-700">{{ __('views.labels.edit') }}</h1>

        {{-- Карточка формы --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200 max-w-2xl">
            {{-- Открываем форму Spatie, связываем с моделью $label и методом PATCH --}}
            {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->class('space-y-4')->novalidate()->open() }}
                {{-- Вставляем тот же общий подшаблон --}}
                @include('labels._form')

                <!-- Кнопка -->
                <div class="pt-2">
                    {{ html()->submit(__('views.buttons.update'))->class('bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm') }}
                </div>

            {{ html()->form()->close() }}
        </div>
    </div>
</div>
@endsection
