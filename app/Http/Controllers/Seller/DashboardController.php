<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'seller']);
    }

    public function index(): View
    {
        $sellerId = auth()->id();

        $productCount = Product::where('user_id', $sellerId)->count();
        $pendingOrders = Order::where('seller_id', $sellerId)
            ->where('status', Order::STATUS_PENDING)
            ->count();
        $completedOrders = Order::where('seller_id', $sellerId)
            ->where('status', Order::STATUS_COMPLETED)
            ->count();
        $totalRevenue = Order::where('seller_id', $sellerId)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_SHIPPED, Order::STATUS_COMPLETED])
            ->sum('subtotal');

        $recentProducts = Product::where('user_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = Order::with(['product', 'buyer'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->take(5)
            ->get();

        return view('seller.dashboard.index', compact(
            'productCount',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'recentProducts',
            'recentOrders'
        ));
    }
}
