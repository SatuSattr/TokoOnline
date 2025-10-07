<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class CartController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $carts = Cart::with(['user', 'product'])->paginate(10);
        return view('admin.carts.index', compact('carts'));
    }

    public function showByUser($userId)
    {
        $user = User::findOrFail($userId);
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
        return view('admin.carts.show', compact('user', 'cartItems'));
    }

    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Cart item deleted successfully.');
    }
}