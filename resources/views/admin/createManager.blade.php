<x-layout>

            <x-setting heading="New Manager">

            <form action="/admin/register-manager" method="POST" class="mt-10">
                @csrf

                <x-form.input name="name" />

                <x-form.input name="username" />

                <x-form.input name="email" />

                <x-form.input name="roles" />

                <x-form.input name="password" />

                <x-form.button>Add</x-form.button>

            </form>

            </x-setting>
</x-layout>
