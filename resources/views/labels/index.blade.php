@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto my-6 px-4 text-stone-700">
    <!-- ЗАГОЛОВОК -->
    <h1 class="text-4xl font-semibold text-gray-900 mb-6 tracking-tight">{{ __('Метки') }}</h1>

    @auth
        <div class="mb-6">
            <a href="{{ route('labels.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition text-sm shadow-sm">
                {{ __('Создать метку') }}
            </a>
        </div>
    @endauth

    <div class="w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm mt-4">
        <table class="w-full text-left border-collapse table-fixed">
            <colgroup>
                <col class="w-[10%]">  <!-- ID -->
                <col class="w-[20%]">  <!-- ИМЯ -->
                <col class="w-[41%]">  <!-- ОПИСАНИЕ -->
                <col class="w-[15%]">  <!-- ДАТА СОЗДАНИЯ -->
                @auth <col class="w-[14%]"> @endauth <!-- ДЕЙСТВИЯ -->
            </colgroup>
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-bold tracking-wider">
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">{{ __('ИМЯ') }}</th>
                    <th class="py-3 px-4">{{ __('ОПИСАНИЕ') }}</th>
                    <th class="py-3 px-4">{{ __('ДАТА СОЗДАНИЯ') }}</th>
                    @auth <th class="py-3 px-4 text-left">{{ __('ДЕЙСТВИЯ') }}</th> @endauth
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                @forelse($labels as $label)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="py-3 px-4 font-mono text-gray-400">{{ $label->id }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900 break-words">{{ $label->name }}</td>
                        <td class="py-3 px-4 text-gray-500 break-words">{{ $label->description ?? '' }}</td>
                        <td class="py-3 px-4 text-gray-500 whitespace-nowrap">{{ $label->created_at->format('d.m.Y') }}</td>
                        
                        @auth
                            <td class="py-3 px-4 text-left whitespace-nowrap text-xs">
                                <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline-block mr-3" onsubmit="return confirm('{{ __('Вы уверены?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium bg-transparent p-0 border-0 cursor-pointer">
                                        {{ __('Удалить') }}
                                    </button>
                                </form>

                                <a href="{{ route('labels.edit', $label) }}" class="text-blue-600 hover:text-blue-900 font-medium no-underline">{{ __('Изменить') }}</a>
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() ? 5 : 4 }}" class="py-8 px-4 text-center text-gray-400 bg-gray-50/50 italic">
                            {{ __('Нет добавленных меток') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
