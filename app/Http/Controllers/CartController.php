<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if (Auth::check()) {
            $user = Auth::user();

            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                $cartItem = new Cart();
                $cartItem->user_id = $user->id;
                $cartItem->product_id = $productId;
                $cartItem->quantity = 1;
                $cartItem->save();
            }


            return back()->with('success', 'Item added to cart');

        } else {
            return redirect()->back()->with('error', 'You must be logged in to add products to the cart.');
        }
    }

    public function showCart()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

            $total = $cartItems->sum(function ($cartItem) {
                return $cartItem->product->price * $cartItem->quantity;
            });

            return view('cart', [
                'cartItems' => Cart::with('product')->where('user_id', $user->id)->get(),
                'total' => $total,
            ]);
        } else {
            return redirect('/login')->with('error', 'You must be logged in to view your cart.');
        }
    }

    public function decreaseQuantity($id)
    {
        $cartItem = Cart::findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }


        return back()->with('success', 'Quantity decreased');
    }

    public function increaseQuantity($id)
    {
        $cartItem = Cart::findOrFail($id);

        $cartItem->increment('quantity');

        return back()->with('success', 'Quantity increased');
    }

    public function removeItem($id)
    {
        $cartItem = Cart::findOrFail($id);

        $cartItem->delete();

        return back()->with('success', 'Item removed');
    }

}