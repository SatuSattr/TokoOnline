<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $usersCount = User::count();
        $productsCount = Product::count();
        $cartsCount = Cart::count();
        $totalRevenue = 0; // This would be calculated based on orders in a real app

        return view('admin.dashboard.index', compact('usersCount', 'productsCount', 'cartsCount', 'totalRevenue'));
    }
}
