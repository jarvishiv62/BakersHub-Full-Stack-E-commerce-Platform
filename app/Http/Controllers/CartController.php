<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Cart session structure:
     * {
     *   "items": {
     *     "{product_id}": {
     *       "id": int,
     *       "name": string,
     *       "price": float,
     *       "qty": int,
     *       "line_total": float
     *     }
     *   },
     *   "total": float
     * }
     */
    
    /**
     * Add a product to the cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        $quantity = (int)$request->quantity;
        
        if (isset($cart['items'][$product->id])) {
            $cart['items'][$product->id]['qty'] += $quantity;
        } else {
            $cart['items'][$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => $quantity,
                'image' => $product->image ?? 'default-product.jpg',
                'line_total' => $product->price * $quantity
            ];
        }
        
        // Update line total and cart total
        $cart['items'][$product->id]['line_total'] = $cart['items'][$product->id]['qty'] * $product->price;
        $cart['total'] = $this->calculateCartTotal($cart['items']);
        
        // Save cart to session
        Session::put('cart', $cart);
        
        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => count($cart['items']),
            'cart_total' => $cart['total']
        ]);
    }
    
    /**
     * Display the cart contents
     */
    public function index()
    {
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        return view('cart.index', compact('cart'));
    }
    
    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cart = Session::get('cart');
        
        if (!isset($cart['items'][$id])) {
            return response()->json(['error' => 'Item not found in cart'], 404);
        }
        
        $quantity = $request->input('quantity', 1);
        $cart['items'][$id]['qty'] = $quantity;
        $cart['items'][$id]['line_total'] = $cart['items'][$id]['price'] * $quantity;
        $cart['total'] = $this->calculateCartTotal($cart['items']);
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'item_total' => $cart['items'][$id]['line_total'],
            'cart_total' => $cart['total']
        ]);
    }
    
    /**
     * Remove an item from the cart
     */
    public function remove($id)
    {
        $cart = Session::get('cart');
        
        if (isset($cart['items'][$id])) {
            unset($cart['items'][$id]);
            $cart['total'] = $this->calculateCartTotal($cart['items']);
            Session::put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'cart_count' => count($cart['items']),
                'cart_total' => $cart['total']
            ]);
        }
        
        return response()->json(['error' => 'Item not found in cart'], 404);
    }
    
    /**
     * Clear the cart
     */
    public function clear()
    {
        Session::forget('cart');
        return response()->json(['success' => true]);
    }
    
    /**
     * Helper method to calculate cart total
     */
    private function calculateCartTotal($items)
    {
        return collect($items)->sum('line_total');
    }
}
