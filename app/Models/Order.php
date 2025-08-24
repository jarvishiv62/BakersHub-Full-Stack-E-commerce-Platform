<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\OrderStatusHistory;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'address',
        'status',
        'total',
        'notes'
    ];
    
    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }
    
    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . date('Ymd') . '-';
        $lastOrder = static::where('order_number', 'like', $prefix . '%')
            ->orderBy('order_number', 'desc')
            ->first();
            
        if ($lastOrder) {
            $number = (int) str_replace($prefix, '', $lastOrder->order_number) + 1;
        } else {
            $number = 1;
        }
        
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    protected $casts = [
        'total' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function statuses()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer',
            'email' => $this->customer_email ?? 'guest@example.com'
        ]);
    }

    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function updateStatus(string $newStatus, ?string $notes = null, ?int $changedBy = null)
    {
        if ($this->status === $newStatus) {
            return false;
        }

        $previousStatus = $this->status;
        $this->status = $newStatus;
        $this->save();

        // Record status change in history
        $this->statusHistory()->create([
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
            'changed_by' => $changedBy ?? Auth::id()
        ]);

        return true;
    }

    public function scopeWithStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeSearch($query, $searchTerm)
    {
        if (!$searchTerm) {
            return $query;
        }

        return $query->where(function($q) use ($searchTerm) {
            $q->where('order_number', 'like', "%{$searchTerm}%")
              ->orWhere('customer_name', 'like', "%{$searchTerm}%")
              ->orWhere('customer_email', 'like', "%{$searchTerm}%")
              ->orWhere('customer_phone', 'like', "%{$searchTerm}%");
        });
    }
}
