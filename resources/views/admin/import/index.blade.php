<x-layout>
    <x-setting heading="Manage Scheduled Imports">

        @if ($imports->where('executed', false)->isEmpty())
            <p class="text-gray-600 text-sm">No imports scheduled.</p>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                scheduled Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Cancel</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imports as $import)
                            @if (!$import->executed)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $import->date }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="font-medium text-blue-500 hover:text-blue-600" type="button"
                                            data-modal-toggle="authentication-modal">
                                            Edit
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="/admin/schedule-import/{{ $import->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="font-medium  text-red-500 hover:text-red-600">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Main modal -->
                                <div id="authentication-modal" aria-hidden="true"
                                    class="hidden overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 left-0 right-0 md:inset-0 z-50 justify-center items-center">
                                    <div class="relative w-full max-w-md px-4 h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div class="bg-white rounded-lg shadow relative dark:bg-gray-700">
                                            <div class="flex justify-end p-2">
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                                    data-modal-toggle="authentication-modal">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="px-6 py-6 lg:px-8">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">Edit
                                                    Scheduled
                                                    Import
                                                </h3>

                                                <form class="space-y-6" method="POST"
                                                    action="/admin/schedule-import/{{ $import->id }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PATCH')
                                                    <x-form.input name="date" type="datetime-local"
                                                        :value="old('date', $import->date)" />

                                                    {{-- <x-form.input name="file" type="file" /> --}}

                                                    <button type="submit"
                                                        class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update
                                                        Schedule
                                                    </button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <script src="https://unpkg.com/@themesberg/flowbite@1.2.0/dist/flowbite.bundle.js"></script>

    </x-setting>
</x-layout>
