@props(['product'])
<article
    {{ $attributes->merge(['class' => 'transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl']) }}>
    <div class="py-6 px-5">
        <div>
            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="" class="rounded-xl object-contain" style="width: 246px; height:369px;">
        </div>

        <div class="mt-8 flex flex-col justify-between">
            <header>


                <div class="mt-4">
                    <h1 class="text-2xl font-semibold">
                        <a href="/products/{{ $product->name }}">
                            {{ ucwords($product->name) }}
                        </a>
                    </h1>
                    <h2 class="text-xl mt-2">
                        ₹{{ number_format($product->price) }}
                    </h2>
                </div>
            </header>

            <footer class="flex justify-between items-center mt-8">

                <div class="space-x-2">
                    {{-- <x-category-button :product="$product->category" /> --}}
                    <a href="/categories/{{ $product->category->name }}"
                        class="px-4 py-2 border border-blue-300 rounded-xl text-blue-300 text-xs uppercase font-semibold"
                        style="font-size: 10px">
                        {{ $product->category->name }}</a>
                </div>

                <div>
                    <form action="/cart/add/{{$product->id}}" method="POST">
                        @csrf
                        <button type="submit"
                            class="transition-colors duration-300 text-xs font-semibold bg-blue-500 text-white hover:bg-blue-600 rounded-xl py-2 px-4">Add
                            to cart
                        </button>
                    </form>
                </div>


            </footer>
        </div>
    </div>
</article>
