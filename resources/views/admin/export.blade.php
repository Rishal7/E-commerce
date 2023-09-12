<x-layout>

    <x-setting heading="Export Data">

        <form method="POST" action="/admin/export" enctype="multipart/form-data">
            @csrf

            <label class="text-sm font-semibold">SELECT CATEGORIES</label>
            <div class="m-2 mb-6">
                @foreach ($categories as $category)
                    <div class="flex items-center mb-2">
                        <input id="default-checkbox" type="checkbox" name="categories[]" id="category{{ $category->id }}"
                            value="{{ $category->id }}"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded  dark:focus:ring-blue-600 dark:ring-offset-gray-800  dark:bg-gray-700 dark:border-gray-600">
                        <label for="category{{ $category->id }}"
                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ ucwords($category->name) }}</label>
                    </div>
                @endforeach
            </div>

            <x-form.button onclick="loadContent()">Export</x-form.button>

        </form>


        @if (!is_null($batch) && $batch->progress() < 100)
            <div id="progress">

            </div>
        @endif


        @if ($down && $batch->progress() == 100)
            <div class="mt-4">
                <a href="/admin/download" class="text-blue-500 hover:underline font-semibold text-sm">Download Exported
                    File</a>
            </div>
        @else
            {{-- <p class="mt-4 text-sm ">No export done.</p> --}}
        @endif

    </x-setting>

    @if (!is_null($batch) && $batch->progress() < 100)
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function loadContent() {
                $.ajax({
                    url: '/admin/export-progress', 
                    type: 'GET',
                    dataType: 'html',
                    success: function(response) {
                        
                        $('#progress').html(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            setInterval(loadContent, 300);
        </script>
    @endif

</x-layout>
