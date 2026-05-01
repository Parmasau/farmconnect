<?php
// app/Http/Controllers/Farmer/AdviceController.php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\AdviceRequest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function index()
    {
        $advice = AdviceRequest::with('agrovet')
                              ->where('farmer_id', Auth::id())
                              ->orderBy('created_at', 'desc')
                              ->paginate(15);
        
        return view('farmer.advice.index', compact('advice'));
    }

    public function create()
    {
        // Get only active agrovets
        $agrovets = User::where('role', 'agrovet')
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
        
        return view('farmer.advice.create', compact('agrovets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agrovet_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $advice = AdviceRequest::create([
            'farmer_id' => Auth::id(),
            'assigned_agrovet_id' => $request->agrovet_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => $request->agrovet_id ? 'assigned' : 'pending',
        ]);

        // Create notification for the specific agrovet if selected
        if ($request->agrovet_id) {
            Notification::create([
                'user_id' => $request->agrovet_id,
                'title' => 'New Advice Request',
                'message' => Auth::user()->name . ' has sent you an advice request: ' . $request->subject,
                'type' => 'advice',
                'data' => ['advice_id' => $advice->id],
            ]);
        } else {
            // Notify all agrovets (optional - you can enable or disable this)
            $agrovets = User::where('role', 'agrovet')->where('is_active', true)->get();
            foreach ($agrovets as $agrovet) {
                Notification::create([
                    'user_id' => $agrovet->id,
                    'title' => 'New Advice Request',
                    'message' => Auth::user()->name . ' needs farming advice: ' . $request->subject,
                    'type' => 'advice',
                    'data' => ['advice_id' => $advice->id],
                ]);
            }
        }

        return redirect()->route('farmer.advice.index')
                         ->with('success', 'Advice request sent successfully!');
    }

    public function show(AdviceRequest $advice)
    {
        abort_if($advice->farmer_id !== Auth::id(), 403);
        
        return view('farmer.advice.show', compact('advice'));
    }
}