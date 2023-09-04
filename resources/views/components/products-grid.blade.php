<div class="lg:grid lg:grid-cols-8">
    @foreach ($products as $product)
        <x-productcard :product="$product" class="col-span-2" />
    @endforeach
</div>
