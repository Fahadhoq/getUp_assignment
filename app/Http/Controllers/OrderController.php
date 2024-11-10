<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $data['parent_orders'] = Order::with(['childOrders.product.category','customer'])  // Eager load the child orders and their products and categories
            ->whereNull('parent_order_id')  // Fetch only parent orders
            ->get();

        // Iterate over the parent orders and group their child orders by product category
        foreach ($data['parent_orders'] as $parent_order) {
            $parent_order->child_orders_grouped = $parent_order->childOrders->groupBy(function ($order) {
                return $order->product->category->name;  // Grouping by product category
            });
        }

        // Now, the $parent_orders collection contains a `child_orders_grouped` attribute for each parent order,
        // which is the child orders grouped by their product category.

        return view('Backend.Order.index' , $data);

    }

}
