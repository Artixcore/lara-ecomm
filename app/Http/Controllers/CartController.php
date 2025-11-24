<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $cartItem = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = ($cartItem->quantity ?? 0) + $request->quantity;
        
        if ($cartItem->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $cartItem->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => Auth::user()->cartItems()->sum('quantity'),
            ]);
        }

        return back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock,
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        if ($request->ajax()) {
            $cartItems = Auth::user()->cartItems()->with('product')->get();
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            
            return response()->json([
                'success' => true,
                'total' => number_format($total, 2),
                'item_total' => number_format($cartItem->product->price * $cartItem->quantity, 2),
            ]);
        }

        return back()->with('success', 'Cart updated');
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => Auth::user()->cartItems()->sum('quantity'),
            ]);
        }

        return back()->with('success', 'Item removed from cart');
    }
}
