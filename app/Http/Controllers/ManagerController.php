<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    public function index()
    {
        return view('manager.products.index', [
            'products' => Product::all()
        ]);
    }

    public function create()
    {
        return view('manager.products.create');
    }

    public function store()
    {

        $attributes = $this->validatePost();
        $attributes['user_id'] = auth()->id();
        $attributes['image'] = request()->file('image')->store('images');

        Product::create($attributes);

        return redirect('/');
    }

    public function edit(Product $product)
    {
        return view('manager.products.edit', ['product' => $product]);
    }

    public function update(Product $product)
    {
        $attributes = $this->validatePost($product);

        if (isset($attributes['image'])) {
            $attributes['image'] = request()->file('image')->store('images');
        }

        $product->update($attributes);

        return back()->with('success', 'Product updated');
    }

    protected function validatePost(?Product $product = null): array
    {
        $product ??= new Product();

        return request()->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => $product->exists ? ['image'] :['required', 'image'],
            'category_id' => ['required', Rule::exists('categories','id')]
        ]);
    }
}
