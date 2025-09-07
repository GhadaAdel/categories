<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function downloadInvoice($orderId)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($orderId);

        $pdf = Pdf::loadView('invoices.order', compact('order'));

        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
