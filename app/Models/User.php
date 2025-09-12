<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, \Illuminate\Auth\Passwords\CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'phone',
        'status',
        'email_verified_at',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_label'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->status)) {
                $user->status = 'active';
            }
        });
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }
    
    /**
     * Get all orders for the user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Get all order items for the user
     */
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
    
    /**
     * Get the user's active (not completed or cancelled) orders
     */
    public function activeOrders()
    {
        return $this->orders()
            ->whereNotIn('status', ['delivered', 'cancelled'])
            ->orderBy('created_at', 'desc');
    }
    
    /**
     * Get the user's completed orders
     */
    public function completedOrders()
    {
        return $this->orders()
            ->where('status', 'delivered')
            ->orderBy('delivered_at', 'desc');
    }
    
    /**
     * Get the user's cancelled orders
     */
    public function cancelledOrders()
    {
        return $this->orders()
            ->where('status', 'cancelled')
            ->orderBy('updated_at', 'desc');
    }
    
    /**
     * Get the user's total spent amount
     *
     * @return float
     */
    public function getTotalSpentAttribute(): float
    {
        return (float) $this->orders()
            ->where('payment_status', 'paid')
            ->sum('total_amount');
    }
    
    /**
     * Get the user's order statistics
     */
    public function getOrderStatisticsAttribute()
    {
        return [
            'total_orders' => $this->orders()->count(),
            'total_spent' => $this->total_spent,
            'avg_order_value' => $this->orders()->avg('total_amount') ?? 0,
            'pending_orders' => $this->orders()->where('status', 'pending')->count(),
            'completed_orders' => $this->completedOrders()->count(),
            'cancelled_orders' => $this->cancelledOrders()->count(),
        ];
    }

    /**
     * Get the status label attribute.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Automatically hash the password when setting it.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * Scope a query to only include inactive users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}

