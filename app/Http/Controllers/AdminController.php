<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::simplePaginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store()
    {
        $attributes = $this->validateProduct();
        $attributes['user_id'] = auth()->id();
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        Product::create($attributes);

        return redirect('/');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Product $product)
    {
        $attributes = $this->validateProduct($product);

        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $product->update($attributes);

        return back()->with('success', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted');
    }

    protected function validateProduct(?Product $product = null): array
    {
        $product ??= new Product();

        return request()->validate([
            'name' => 'required',
            'price' => 'required',
            'thumbnail' => $product->exists ? ['image'] : ['required', 'image'],
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);
    }

    public function createManager()
    {
        return view('admin.createManager');
    }
    public function storeManager()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'roles' => 'required',
            'password' => 'required|min:8', //['required', 'min:8']
        ]);

        $user = User::create($attributes);

        return back()->with('success', 'Manager has been created');
    }
}