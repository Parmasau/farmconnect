<?php
// app/Http/Controllers/Farmer/AdviceController.php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\AdviceRequest;
use App\Models\User;
use App\Services\FarmerDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function index()
    {
        $advice = AdviceRequest::with('agrovet')
                              ->where('farmer_id', Auth::id())
                              ->latest()
                              ->paginate(15);
        
        $stats = app(FarmerDashboardService::class)->getStats();
        $recentProducts = app(FarmerDashboardService::class)->getRecentProducts();
        $recentOrders = app(FarmerDashboardService::class)->getRecentOrders();
        
        return view('farmer.advice.index', compact('advice', 'stats', 'recentProducts', 'recentOrders'));
    }

    public function create()
    {
        $agrovets = User::where('role', 'agrovet')->where('is_active', true)->get();
        $stats = app(FarmerDashboardService::class)->getStats();
        $recentProducts = app(FarmerDashboardService::class)->getRecentProducts();
        $recentOrders = app(FarmerDashboardService::class)->getRecentOrders();
        
        return view('farmer.advice.create', compact('agrovets', 'stats', 'recentProducts', 'recentOrders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agrovet_id' => 'nullable|exists:users,id',
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
        ]);

        AdviceRequest::create([
            'farmer_id' => Auth::id(),
            'assigned_agrovet_id' => $data['agrovet_id'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => $data['agrovet_id'] ? 'assigned' : 'pending',
        ]);
        
        return redirect()->route('farmer.advice.index')
                         ->with('success', 'Advice request sent successfully!');
    }

    public function show(AdviceRequest $advice)
    {
        abort_if($advice->farmer_id !== Auth::id(), 403);
        
        $stats = app(FarmerDashboardService::class)->getStats();
        $recentProducts = app(FarmerDashboardService::class)->getRecentProducts();
        $recentOrders = app(FarmerDashboardService::class)->getRecentOrders();
        
        return view('farmer.advice.show', compact('advice', 'stats', 'recentProducts', 'recentOrders'));
    }

    public function availableAgrovets()
    {
        $agrovets = User::where('role', 'agrovet')->where('is_active', true)->get();
        return view('farmer.advice.agrovets', compact('agrovets'));
    }
}