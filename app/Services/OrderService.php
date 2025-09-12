<?php
// app/Services/OrderService.php
namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrder(array $data, $userId): Order
    {
        return DB::transaction(function () use ($data, $userId) {
            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'shipping_address' => $data['shipping_address'],
                'billing_address' => $data['billing_address'] ?? $data['shipping_address'],
                'payment_method' => $data['payment_method'] ?? null,
                'notes' => $data['notes'] ?? null,
                'shipping_amount' => $data['shipping_amount'] ?? 0,
                'tax_amount' => $data['tax_amount'] ?? 0,
                'discount_amount' => $data['discount_amount'] ?? 0,
            ]);

            // Create order items
            foreach ($data['items'] as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);

                // Check stock availability
                if ($product->stock < $itemData['quantity']) {
                    throw new Exception("Insufficient stock for product: {$product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'price' => $product->price,
                    'quantity' => $itemData['quantity'],
                    'product_options' => $itemData['product_options'] ?? null,
                ]);

                // Update product stock
                $product->decrement('stock', $itemData['quantity']);
            }

            // Calculate totals
            $order->calculateTotals();

            return $order->load('items', 'user');
        });
    }

    public function updateOrderStatus(Order $order, string $status, ?int $changedBy = null, ?string $notes = null): Order
    {
        return DB::transaction(function () use ($order, $status, $changedBy, $notes) {
            $previousStatus = $order->status;
            
            // Update order status
            $order->update(['status' => $status]);
            
            // Handle status-specific logic
            switch ($status) {
                case 'shipped':
                    $order->update(['shipped_at' => now()]);
                    break;
                case 'delivered':
                    $order->update(['delivered_at' => now()]);
                    break;
                case 'cancelled':
                    $this->restoreStock($order);
                    break;
            }
            
            // Record status change in history
            $this->recordStatusChange($order, $previousStatus, $status, $changedBy, $notes);
            
            // Dispatch notification event
            event(new OrderStatusUpdated($order, $previousStatus, $status));
            
            return $order->load('statusHistory');
        });
    }

    private function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }
    }
    
    /**
     * Record order status change in history
     */
    private function recordStatusChange(
        Order $order, 
        ?string $previousStatus, 
        string $newStatus, 
        ?int $changedBy = null,
        ?string $notes = null
    ): void {
        OrderStatusHistory::create([
            'order_id' => $order->id,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'changed_by' => $changedBy,
            'notes' => $notes,
        ]);
    }
}