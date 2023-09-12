<!doctype html>

<title>E-commerce</title>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:justify-between md:items-center ">
            <div>
                <a href="/">
                    <h1 class="font-semibold text-3xl text-gray-600">E-commerce</h1>
                </a>
            </div>

            <div class="mt-8 md:mt-0 flex items-center">
                @auth

                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="text-xs font-bold uppercase">Welcome, {{ auth()->user()->name }}</button>
                        </x-slot>

                        @admin
                            <x-dropdown-item href="/admin/products" :active="request()->is('admin/products')">Dashboard</x-dropdown-item>
                            <x-dropdown-item href="/admin/products/create" :active="request()->is('admin/products/create')">New Product</x-dropdown-item>
                        @endadmin

                        @manager
                            <x-dropdown-item href="/manager/products" :active="request()->is('manager/products')">Dashboard</x-dropdown-item>
                            <x-dropdown-item href="/manager/products/create" :active="request()->is('manager/products/create')">New Product</x-dropdown-item>
                        @endmanager

                        <x-dropdown-item href="#" x-data="{}"
                            @click.prevent="document.querySelector('#logout-form').submit()">Log Out</x-dropdown-item>

                        <form id="logout-form" action="/logout" method="POST" class="hidden">
                            @csrf
                        </form>

                    </x-dropdown>
                @else
                    <a href="/register" class="text-xs font-bold uppercase"> Register </a>
                    <a href="/login" class="text-xs ml-3 font-bold uppercase"> Log In </a>
                @endauth

                <a href="/cart">
                    <img src="/images/shopping-cart 4.40.26 PM.png" class="ml-4 w-6 h-6">
                </a>
            </div>
        </nav>

        {{ $slot }}


    </section>

    <x-flash />

</body>
