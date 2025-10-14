<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display checkout summary.
     */
    public function create(Request $request): RedirectResponse|View
    {
        $cartItems = Cart::with('product.seller')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        return view('checkout.index', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Process checkout and create order per cart item.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*' => ['integer', 'exists:carts,id'],
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->whereIn('id', $validated['items'])
            ->get();

        if ($cartItems->count() !== count($validated['items'])) {
            return $this->respondCheckoutFailure($request, 'Beberapa item tidak ditemukan di keranjang kamu.');
        }

        DB::transaction(function () use ($cartItems, $validated) {
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $unitPrice = $this->resolveUnitPrice($product->price, $product->disc_price);
                $quantity = $cartItem->quantity;

                Order::create([
                    'user_id' => Auth::id(),
                    'seller_id' => $product->user_id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $unitPrice * $quantity,
                    'status' => 'pending',
                    'shipping_method' => $validated['shipping_method'],
                    'payment_method' => $validated['payment_method'],
                    'shipping_address' => $validated['shipping_address'],
                    'notes' => $validated['notes'] ?? null,
                ]);

                $cartItem->delete();
            }
        });

        $redirectUrl = route('orders.index');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Checkout berhasil! Pesanan kamu sedang diproses.',
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl)->with('success', 'Checkout berhasil! Pesanan kamu sedang diproses.');
    }

    private function resolveUnitPrice($price, $discPrice): float
    {
        $priceValue = (float) $price;
        $discountedValue = is_null($discPrice) ? null : (float) $discPrice;

        if (!is_null($discountedValue) && $discountedValue > 0 && $discountedValue < $priceValue) {
            return $discountedValue;
        }

        return $priceValue;
    }

    private function respondCheckoutFailure(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 422);
        }

        return redirect()->route('cart.index')->with('error', $message);
    }
}
