<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log as Logger;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form
     */
    public function index()
    {
        $cart = Session::get('cart', ['items' => [], 'total' => 0]);
        
        if (empty($cart['items'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        return view('checkout.index', compact('cart'));
    }
    
    /**
     * Process the checkout
     */
    public function store(Request $request)
    {
        Log::info('Checkout request received', ['request_data' => $request->all()]);
        
        $cart = Session::get('cart');
        Log::info('Current cart data', ['cart' => $cart]);
        
        if (empty($cart['items'])) {
            Log::warning('Attempted checkout with empty cart');
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'address' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        Log::info('Form validation passed', ['validated' => $validated]);
        
        try {
            DB::beginTransaction();
            
            // Create the order
            $order = new Order();
            $order->user_id = Auth::id();
            $order->customer_name = $validated['customer_name'];
            $order->customer_phone = $validated['customer_phone'];
            $order->address = $validated['address'];
            $order->notes = $request->input('notes');
            $order->total = $cart['total'];
            $order->save();
            
            // Add order items
            foreach ($cart['items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['id'];
                $orderItem->name = $item['name'];
                $orderItem->price = $item['price'];
                $orderItem->qty = $item['qty'];
                $orderItem->line_total = $item['line_total'];
                $orderItem->save();
            }
            
            DB::commit();
            
            // Clear the cart once
            Session::forget('cart');
            Logger::info('Order created successfully', ['order_id' => $order->id]);
            
            // Redirect to success page
            return redirect()->route('order.success', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Logger::error('Checkout error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'There was an error processing your order. Please try again.');
        }
    }
    
    /**
     * Show the order success page
     */
    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        
        // Verify that the order belongs to the current user if user is logged in
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('checkout.success', compact('order'));
    }
}
