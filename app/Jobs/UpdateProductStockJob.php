<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateProductStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('orderItems.product');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->order->orderItems as $item) {
            $product = $item->product;

            if($product && $product->stock >= $item->quantity) {
                $product->decrement('stock', $item->quantity);
            }

            // if($product) {
            //     $product->stock -= $item->quantity;
            //     $product->save();
            // }
        }
    }
}
