<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the orders with filters
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])
            ->latest();

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Apply search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15);
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }
    
    /**
     * Display the specified order
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        
        // Add breadcrumb or any additional data needed for the view
        $breadcrumbs = [
            ['url' => route('admin.orders.index'), 'title' => 'Orders'],
            ['title' => 'Order #' . $order->id]
        ];
            
        return view('admin.orders.show', compact('order', 'breadcrumbs'));
    }
    
    /**
     * Update the order status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order)
    {        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        try {
            $success = $order->updateStatus(
                $validated['status'],
                $validated['notes'] ?? null,
                auth()->id()
            );
            
            if (!$success) {
                return $this->jsonOrRedirect(
                    $request,
                    false,
                    'Order status is already set to ' . ucfirst($validated['status']),
                    200
                );
            }
            
            // Handle any additional logic based on status change
            $this->handleOrderStatusUpdate($order, $order->status, $validated['status']);
            
            return $this->jsonOrRedirect(
                $request,
                true,
                'Order status updated successfully to ' . ucfirst($validated['status']),
                200,
                [
                    'status' => $validated['status'],
                    'status_label' => ucfirst($validated['status'])
                ]
            );
            
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            
            return $this->jsonOrRedirect(
                $request,
                false,
                'Failed to update order status: ' . $e->getMessage(),
                500
            );
        }
    }
    
    /**
     * Handle order status update events
     *
     * @param  \App\Models\Order  $order
     * @param  string  $previousStatus
     * @param  string  $newStatus
     * @return void
     */
    protected function handleOrderStatusUpdate(Order $order, string $previousStatus, string $newStatus)
    {
        // Add any business logic for status changes here
        // Example: Send email notifications, update inventory, etc.
        
        // Example: Send email notification when order is shipped
        if ($newStatus === 'shipped' && $previousStatus !== 'shipped') {
            // $order->user->notify(new OrderShipped($order));
        }
        
        // Example: Restore inventory if order is cancelled
        if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
            // $this->restoreOrderInventory($order);
        }
    }
    
    /**
     * Handle JSON or redirect response
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $success
     * @param  string  $message
     * @param  int  $statusCode
     * @param  array  $additionalData
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function jsonOrRedirect(Request $request, bool $success, string $message, int $statusCode = 200, array $additionalData = [])
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge([
                'success' => $success,
                'message' => $message
            ], $additionalData), $statusCode);
        }
        
        $status = $success ? 'success' : 'error';
        return back()->with($status, $message);
    }
}
