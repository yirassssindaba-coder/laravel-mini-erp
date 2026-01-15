<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function calculateStock(): int
    {
        $in = $this->inventoryMovements()->where('type', 'in')->sum('quantity');
        $out = $this->inventoryMovements()->where('type', 'out')->sum('quantity');
        return $in - $out;
    }

    public function updateStockFromMovements(): void
    {
        $this->stock = $this->calculateStock();
        $this->save();
    }
}
