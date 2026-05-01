<?php
// app/Http/Controllers/Agrovet/AdviceController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\AdviceRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function index()
    {
        // Show only advice requests assigned to this agrovet
        $adviceRequests = AdviceRequest::where('assigned_agrovet_id', Auth::id())
                                      ->orWhereNull('assigned_agrovet_id')
                                      ->with('farmer')
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(15);
        
        $stats = [
            'total' => AdviceRequest::where('assigned_agrovet_id', Auth::id())->orWhereNull('assigned_agrovet_id')->count(),
            'pending' => AdviceRequest::where(function($q) {
                            $q->where('assigned_agrovet_id', Auth::id())
                              ->orWhereNull('assigned_agrovet_id');
                          })->where('status', 'pending')->count(),
            'assigned' => AdviceRequest::where('assigned_agrovet_id', Auth::id())->where('status', 'assigned')->count(),
            'answered' => AdviceRequest::where('assigned_agrovet_id', Auth::id())->where('status', 'answered')->count(),
        ];
        
        return view('agrovet.advice.index', compact('adviceRequests', 'stats'));
    }

    public function show(AdviceRequest $advice)
    {
        // Check if advice is assigned to this agrovet or unassigned
        if ($advice->assigned_agrovet_id !== null && $advice->assigned_agrovet_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.advice.show', compact('advice'));
    }

    public function respond(Request $request, AdviceRequest $advice)
    {
        // Check if advice is assigned to this agrovet or unassigned
        if ($advice->assigned_agrovet_id !== null && $advice->assigned_agrovet_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'response' => 'required|string|min:10',
        ]);

        $advice->update([
            'assigned_agrovet_id' => Auth::id(),
            'response' => $request->response,
            'status' => 'answered',
            'responded_at' => now(),
        ]);

        // Notify the farmer
        Notification::create([
            'user_id' => $advice->farmer_id,
            'title' => 'Advice Request Answered',
            'message' => 'Your advice request "' . $advice->subject . '" has been answered.',
            'type' => 'advice',
            'data' => ['advice_id' => $advice->id],
        ]);

        return redirect()->route('agrovet.advice.show', $advice)
                         ->with('success', 'Response sent successfully to the farmer!');
    }
    
    public function assign(Request $request, AdviceRequest $advice)
    {
        $request->validate([
            'agrovet_id' => 'required|exists:users,id',
        ]);

        $advice->update([
            'assigned_agrovet_id' => $request->agrovet_id,
            'status' => 'assigned',
        ]);

        return back()->with('success', 'Advice request assigned successfully.');
    }
}