<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'seller']);
    }

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $query = Order::with(['product', 'buyer'])
            ->where('seller_id', auth()->id())
            ->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('seller.orders.index', [
            'orders' => $orders,
            'selectedStatus' => $status,
            'statuses' => Order::availableStatuses(),
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->ensureSellerOwnsOrder($order);

        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::availableStatuses())),
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    private function ensureSellerOwnsOrder(Order $order): void
    {
        if ($order->seller_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }
    }
}
