<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_address',
        'status',
        'total',
        'source',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function marketplacePushLogs(): HasMany
    {
        return $this->hasMany(MarketplacePushLog::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->orderBy('id', 'desc')->first();
        $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -4)) + 1) : 1;
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotal(): void
    {
        $this->total = $this->items()->sum('subtotal');
        $this->save();
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'new' => 'bg-blue-100 text-blue-800',
            'packed' => 'bg-yellow-100 text-yellow-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'done' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
