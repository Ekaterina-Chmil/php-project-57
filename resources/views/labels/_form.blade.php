<!-- Имя метки -->
<div>
    {{ html()->label(__('views.attributes.name'), 'name')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->text('name')->id('name')->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm')->required() }}
    @error('name')
        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
    @enderror
</div>

<!-- Описание метки -->
<div>
    {{ html()->label(__('views.attributes.description'), 'description')->class('block text-sm font-medium text-gray-700 mb-1') }}
    {{ html()->textarea('description')->id('description')->rows(4)->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full text-sm') }}
    @error('description')
        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
    @enderror
</div>
