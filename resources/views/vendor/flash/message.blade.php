@if (session()->has('flash_notification'))
    @foreach (session('flash_notification') as $message)
        <div class="p-4 mb-4 text-sm text-green-800 bg-green-50 rounded-lg border border-green-200" role="alert">
            {{ $message['message'] }}
        </div>
    @endforeach
@endif

