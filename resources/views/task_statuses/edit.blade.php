<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 mb-6">
            Изменение статуса
        </h1>

        <!-- Форма отправляет PATCH запрос на обновление конкретного статуса -->
        <form method="POST" action="{{ route('task_statuses.update', $taskStatus) }}" class="max-w-md bg-white p-6 rounded shadow-sm border border-gray-200">
            @csrf
            @method('PATCH') <!-- Это обязательно для роутов обновления в Laravel -->

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Имя</label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $taskStatus->name) }}" 
                       class="w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded shadow transition text-sm">
                Обновить
            </button>
        </form>
    </div>
</x-app-layout>
