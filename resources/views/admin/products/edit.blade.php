<x-layout>

    <x-setting :heading="'Edit Product: ' . $product->name">

        <form method="POST" action="/admin/products/{{$product->id}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <x-form.input name="name" :value="old('name', $product->name)" />

            <x-form.input name="price" :value="old('price', $product->price)" />

            <div class="flex mt-6">

                <div class="flex-1">
                    <x-form.input name="image" type="file" :value="old('image', $product->image)" />
                </div>

                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="" class="rounded-xl ml-6"
                    width="100">
            </div>

            <div class="mb-6">

                <x-form.label name="category" />

                <select name="category_id" id="category_id">

                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ ucwords($category->name) }}</option>
                    @endforeach

                </select>

                <x-form.error name="category" />

            </div>

            <x-form.button>Update</x-form.button>

        </form>

    </x-setting>


</x-layout>
