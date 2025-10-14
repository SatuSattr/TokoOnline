<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $orders = Order::with(['product', 'seller'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
}
