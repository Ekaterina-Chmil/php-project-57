<!-- Имя -->
<div>
    {{ html()->label(__('views.attributes.name'), 'name')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->text('name')->id('name')->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm')->required() }}
    @error('name') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Описание -->
<div>
    {{ html()->label(__('views.attributes.description'), 'description')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->textarea('description')->id('description')->rows(4)->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm') }}
    @error('description') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Статус -->
<div>
    {{ html()->label(__('views.attributes.status'), 'status_id')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->select('status_id', $statuses)->id('status_id')->placeholder('')->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2')->required() }}
    @error('status_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Исполнитель -->
<div>
    {{ html()->label(__('views.attributes.assigned_to'), 'assigned_to_id')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->select('assigned_to_id', $users)->id('assigned_to_id')->placeholder('')->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm py-2') }}
    @error('assigned_to_id') <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Метки задачи -->
<div class="space-y-2">
    {{ html()->label(__('views.attributes.labels'), 'labels')->class('block text-sm font-medium text-gray-700') }}
    <div class="grid grid-cols-2 gap-2 bg-gray-50 p-3 rounded border border-gray-200">
        @foreach($labels as $id => $name)
            <div class="flex items-center">
                {{-- Метод ->value($id) передает ID метки, а Spatie сам проверит связи и поставит checked, если метка привязана к задаче --}}
                {{ html()->checkbox('labels[]')->value($id)->id('label_' . $id)->class('rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50') }}
                {{ html()->label($name, 'label_' . $id)->class('ml-2 text-sm text-gray-600') }}
            </div>
        @endforeach
    </div>
</div>
