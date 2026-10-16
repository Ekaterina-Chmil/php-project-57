<!-- Имя статуса -->
<div>
    {{ html()->label(__('views.attributes.status_name'), 'name')->class('block font-medium text-sm text-gray-700 mb-1') }}
    {{ html()->text('name')->id('name')->class('rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full')->required() }}
    @error('name')
        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
    @enderror
</div>
