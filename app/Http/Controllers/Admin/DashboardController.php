<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Consultation;
use App\Models\AdviceRequest;
use App\Models\Message;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalFarmers = User::where('role', 'farmer')->count();
        $totalAgrovets = User::where('role', 'agrovet')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalConsultations = Consultation::count();
        $totalAdvice = AdviceRequest::count();
        $totalMessages = Message::count();
        $unreadMessages = Message::whereNull('read_at')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $recentUsers = User::latest()->limit(5)->get();
        $recentOrders = Order::with('buyer')->latest()->limit(5)->get();
        $recentProducts = Product::with('farmer')->latest()->limit(5)->get();
        $recentMessages = Message::with(['sender', 'receiver'])->latest()->limit(5)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalFarmers', 'totalAgrovets', 'totalAdmins',
            'totalProducts', 'totalOrders', 'totalRevenue', 'totalConsultations',
            'totalAdvice', 'totalMessages', 'unreadMessages', 'pendingOrders',
            'recentUsers', 'recentOrders', 'recentProducts', 'recentMessages'
        ));
    }
}