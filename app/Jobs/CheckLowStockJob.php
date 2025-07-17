<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\LowStockAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckLowStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('orderItems.product', 'user');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->order->orderItems as $item) {
            $product = $item->product;

            if($product && $product->stock <= 5) {
                Mail::to($this->order->user->email)->send(new LowStockAlert($product));
            }
        }
    }
}
