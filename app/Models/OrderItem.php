<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'description',
        'price',
        'qty',
        'line_total',
        'sku',
        'options',
        'weight',
        'tax_amount',
        'discount_amount'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'qty' => 'integer',
        'weight' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            $orderItem->line_total = $orderItem->calculateLineTotal();
        });
    }

    public function calculateLineTotal()
    {
        return round($this->price * $this->qty, 2);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function getFormattedPriceAttribute()
    {
        $price = (float) $this->price;
        return '₹' . number_format($price, 2);
    }

    public function getFormattedLineTotalAttribute()
    {
        $total = (float) $this->line_total;
        return '₹' . number_format($total, 2);
    }

    public function getOptionsListAttribute()
    {
        if (empty($this->options)) {
            return [];
        }

        return collect($this->options)->map(function ($value, $key) {
            return [
                'name' => ucwords(str_replace('_', ' ', $key)),
                'value' => $value
            ];
        })->toArray();
    }
}
