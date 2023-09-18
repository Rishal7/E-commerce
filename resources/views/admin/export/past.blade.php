<x-layout>
    <x-setting heading="Manage Scheduled Imports">

        @if ($exports->where('executed', true)->isEmpty())
            <p class="text-gray-600 text-sm">No previous exports.</p>
        @else
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Exported Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-right">
                                Completion
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exports as $export)
                        @if ($export->executed)
                            <tr
                                class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ $export->date }}
                                </td>
                                <td class="px-6 py-4 text-blue-400 text-right">
                                        Completed
                                </td>
                                
                            </tr>
                            
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </x-setting>
</x-layout>
