<x-layout>

            <x-setting heading="Add New Product">

            <form action="/admin/register-manager" method="POST" class="mt-10">
                @csrf

                <x-form.input name="name" />

                <x-form.input name="username" />

                <x-form.input name="email" />

                <x-form.input name="roles" />

                <x-form.input name="password" />

                <x-form.button>Add</x-form.button>

                {{-- <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name">Name
                    </label>

                    <input class="border border-gray-400 p-2 w-full" type="text" name="name" id="name"
                        value="{{ old('name') }}" required>

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="username">Username
                    </label>

                    <input class="border border-gray-400 p-2 w-full" type="text" name="username" id="username"
                        value="{{ old('username') }}" required>

                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">Email
                    </label>

                    <input class="border border-gray-400 p-2 w-full" type="text" name="email" id="email"
                        value="{{ old('email') }}" required>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="roles">Role
                    </label>

                    <input class="border border-gray-400 p-2 w-full" type="text" name="roles" id="roles"
                        value="{{ old('roles') }}" required>

                    @error('roles')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password">Password
                    </label>

                    <input class="border border-gray-400 p-2 w-full" type="password" name="password" id="password"
                        required>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div> --}}
                {{-- <div class="mb-6">
                    <button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">
                        Submit
                    </button>
                </div> --}}



            </form>

            </x-setting>
</x-layout>
