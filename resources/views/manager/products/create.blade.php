<x-layout>

    <x-setting heading="Add New Product">

        <form method="POST" action="/manager/products" enctype="multipart/form-data">

            @csrf

            <x-form.input name="name" />

            <x-form.input name="price" />

            <x-form.input name="image" type="file" />

            <div class="mb-6">

                <x-form.label name="category" />

                <select name="category_id" id="category_id">

                    @foreach (\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ ucwords($category->name) }}</option>
                    @endforeach

                </select>

                <x-form.error name="category" />

            </div>

            <x-form.button>Publish</x-form.button>

        </form>

    </x-setting>


</x-layout>
