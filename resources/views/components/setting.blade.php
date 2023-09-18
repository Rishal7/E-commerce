@props(['heading'])

<section class="py-8 max-w-4xl mx-auto">

    <h1 class="text-2xl text-gray-700 font-semibold mb-8 pb-2 border-b">
        {{ $heading}}
    </h1>

    <div class="flex">
        <aside class="w-48 flex-shrink-0">

            <h4 class="font-semibold mb-4">Links</h4>
            @admin
            <ul>
                <li class="mb-1">
                    <a href="/admin/products" class="{{ request()->is('admin/products') ? 'text-blue-500' : ''}}">All Products</a>
                </li>

                <li class="mb-1"> 
                    <a href="/admin/products/create" class="{{ request()->is('admin/products/create') ? 'text-blue-500' : ''}}">New Product</a>
                </li>

                <li class="mb-2">
                    <a href="/admin/register-manager" class="{{ request()->is('admin/register-manager') ? 'text-blue-500' : ''}}">New Manager</a>
                </li>

                <div class="border border-b mb-2 mr-12"></div>

                <li class="mb-1">
                    <a href="/admin/import" class="{{ request()->is('admin/import') ? 'text-blue-500' : ''}}">Import</a>
                </li>

                <li class="mb-1">
                    <a href="/admin/schedule-import" class="{{ request()->is('admin/schedule-import') ? 'text-blue-500' : ''}}">Scheduled Imports</a>
                </li>

                <li class="mb-2 ">
                    <a href="/admin/schedule-import/history" class="{{ request()->is('admin/schedule-import/history') ? 'text-blue-500' : ''}}">Past Imports</a>
                </li>

                <div class="border border-b mb-2 mr-12"></div>

                <li class="mb-1">
                    <a href="/admin/export" class="{{ request()->is('admin/export') ? 'text-blue-500' : ''}}">Export</a>
                </li>

                <li class="mb-1 ">
                    <a href="/admin/schedule-export" class="{{ request()->is('admin/schedule-export') ? 'text-blue-500' : ''}} ">Scheduled Exports</a>
                </li>

                <li class="mb-1">
                    <a href="/admin/schedule-export/history" class="{{ request()->is('admin/schedule-export/history') ? 'text-blue-500' : ''}}">Past Exports</a>
                </li>
            </ul>
            @endadmin

            @manager
            <ul>
                <li class="mb-2">
                    <a href="/manager/products" class="{{ request()->is('manager/products') ? 'text-blue-500' : ''}}">All Products</a>
                </li>

                <li>
                    <a href="/manager/products/create" class="{{ request()->is('manager/products/create') ? 'text-blue-500' : ''}}">New Product</a>
                </li>
            </ul>
            @endmanager
        </aside>
    
        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
    
</section>