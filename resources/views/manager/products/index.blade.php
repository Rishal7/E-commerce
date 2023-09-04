<x-layout>
    <x-setting heading="Manage Products">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <a href="/products/{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                            {{-- @admin
                                            <a href="/admin/products/{{ $product->id }}/edit"
                                                class="text-blue-500 hover:text-blue-600">Edit</a>
                                            @endadmin --}}

                                            {{-- @manager --}}
                                            <a href="/manager/products/{{ $product->id }}/edit"
                                                class="text-blue-500 hover:text-blue-600">Edit</a>
                                            {{-- @endmanager --}}

                                        </td>
                                        {{-- @admin
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form method="POST" action="/admin/products/{{ $product->id }}">
                                                @csrf
                                                @method('DELETE')

                                                <button class="text-xs text-gray-400">Delete</button>
                                            </form>
                                        </td>
                                        @endadmin --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-setting>
</x-layout>
