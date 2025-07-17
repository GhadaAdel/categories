<?php

namespace App\Models;

use App\Jobs\CheckLowStockJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_address',
        'billing_address',
        'placed_at',
        'shipped_at',
        'payment_method'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::updated(function (Order $order) {
            if ($order->isDirty('status') && $order->status === 'shipped') {
                CheckLowStockJob::dispatch($order);
            }
        });
    }
}
