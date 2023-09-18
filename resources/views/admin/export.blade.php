<x-layout>

    <x-setting heading="Export Data">



        <!-- This is an example component -->
<div class="max-w-2xl mx-auto">
 
    <!-- Modal toggle -->
    <label class="block mb-3 font-semibold text-base text-gray-700">Schedule an export</label>
    <button class=" bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-6 rounded-lg hover:bg-blue-600" type="button" data-modal-toggle="authentication-modal">
    Schedule
    </button>

    <div class="border border-b my-6"></div>

    <!-- Main modal -->
    <div id="authentication-modal" aria-hidden="true" class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
        <div class="relative w-full max-w-md px-4 h-full md:h-auto">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow relative ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="authentication-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <form class="space-y-6 px-6 lg:px-8 pb-4 sm:pb-6 xl:pb-8" method="POST" action="/admin/schedule-export" enctype="multipart/form-data">
                    @csrf

                    <h3 class="text-xl font-medium text-gray-900 ">Schedule an export</h3>

                    <x-form.input name="date" type="datetime-local" />

                    <div class="m-2 mb-6">
                        @foreach ($categories as $category)
                            <div class="flex items-center mb-2">
                                <input id="default-checkbox" type="checkbox" name="categories[]" id="category{{ $category->id }}"
                                    value="{{ $category->id }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                                <label for="category{{ $category->id }}"
                                    class="ml-2 text-sm font-medium text-gray-900 ">{{ ucwords($category->name) }}</label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Schedule Export</button>
                    
                </form>
            </div>
        </div>
    </div> 

</div>

<script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>


<p class="block mb-3 font-semibold text-base text-gray-700">Export now</p>

        <form method="POST" action="/admin/export" enctype="multipart/form-data">
            @csrf

            <label class="text-sm font-semibold">Select Categories</label>
            <div class="m-2 mb-6">
                @foreach ($categories as $category)
                    <div class="flex items-center mb-2">
                        <input id="default-checkbox" type="checkbox" name="categories[]" id="category{{ $category->id }}"
                            value="{{ $category->id }}"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded">
                        <label for="category{{ $category->id }}"
                            class="ml-2 text-sm font-medium text-gray-900 ">{{ ucwords($category->name) }}</label>
                    </div>
                @endforeach
            </div>

            <x-form.button onclick="loadContent()">Export</x-form.button>

        </form>

        <div id="progress">

        </div>

    </x-setting>

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

</x-layout>
