<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {

        $order = $event->order;

        try {
            foreach ($order->products as $product) {

                $product->decrement('quantity', $product->order_item->quantity);

                // Product::where('id', '=', $item->product_id)
                //     ->update([
                //         'quantity' => DB::raw("quantity - {$item->quantity}"),
                //     ]);
            }
        } catch (Throwable $e) {

        }
    }
}
