<x-layout>
<style>
    @layer utilities {
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  }
</style>

<body>
  <div class="h-screen pt-20">
    <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
    <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
      <div class="rounded-lg md:w-2/3">

        @if ($cartItems->count() > 0)
        @foreach ($cartItems as $cartItem)

        <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">

            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
            <div class="mt-5 sm:mt-0">
              <h2 class="text-lg font-bold text-gray-900"><a href="/products/{{ $cartItem->product->name }}">{{ ucwords($cartItem->product->name) }}</a></h2>
              <h2 class="text-sm mt-2">₹ {{ number_format($cartItem->product->price) }}</h2>
            </div>
            <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
              <div class="flex items-center border-gray-100">

                <form method="POST" action="/cart/decrease/{{$cartItem->id}}"
                    class="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50"  >
                    @csrf
                    @method('patch')
                    <button type="submit" >
                        -
                    </button>
                </form>

                <div class="h-8 w-8 border bg-white text-center text-sm outline-none"> <p class="mt-1">{{ $cartItem->quantity }}</p></div>

                <form method="POST" action="/cart/increase/{{$cartItem->id}}"
                    class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50"  >
                    @csrf
                    @method('patch')
                    <button type="submit" class="w-full">
                        +
                    </button>
                </form>

              </div>
              <div class="flex items-center space-x-4">
                <form method="POST" action="/cart/remove/{{$cartItem->id}}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-sm px-2 py-1 text-red-500">
                        Remove
                    </button>
                </form>
              </div>
            </div>
          </div>
        </div>
        @endforeach

        @else
            <p>Your cart is empty.</p>
        @endif
      </div>
      
      
      <!-- Sub total -->

      <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
        <div class="mb-2 flex justify-between">
          <p class="text-gray-700">Subtotal</p>
          <p class="text-gray-700">₹{{ number_format($total) }}</p>
        </div>

        <div class="flex justify-between">
          <p class="text-gray-700">Shipping</p>
          <p class="text-gray-700">₹ 0</p>
        </div>

        <hr class="my-4" />

        <div class="flex justify-between">
          <p class="text-lg font-bold">Total</p>
          <div class="">
            <p class="mb-1 text-lg font-bold">₹ {{ number_format($total) }}</p>
          </div>
        </div>
        <button class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check out</button>
      </div>
    </div>
  </div>
</body>
</x-layout>