@if (session()->has('success'))
        <div x-data="{ show: true}"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            class="fixed bottom-3 right-3 bg-blue-500 rounded-xl text-white py-2 px-4 text-sm">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
    <div x-data="{ show: true}"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="fixed bottom-3 right-3 bg-red-500 rounded-xl text-white py-2 px-4 text-sm">
        <p>{{ session('error') }}</p>
    </div>
@endif