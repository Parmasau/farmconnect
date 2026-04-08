<?php
// app/Http/Controllers/Agrovet/AdviceController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\AdviceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdviceController extends Controller
{
    public function index()
    {
        $adviceRequests = AdviceRequest::where(function($query) {
                $query->where('assigned_agrovet_id', Auth::id())
                      ->orWhereNull('assigned_agrovet_id');
            })
            ->with('farmer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => AdviceRequest::count(),
            'pending' => AdviceRequest::where('status', 'pending')->count(),
            'assigned' => AdviceRequest::where('assigned_agrovet_id', Auth::id())->where('status', 'assigned')->count(),
            'answered' => AdviceRequest::where('assigned_agrovet_id', Auth::id())->where('status', 'answered')->count(),
        ];
        
        return view('agrovet.advice.index', compact('adviceRequests', 'stats'));
    }

    public function show($adviceRequest)
    {
        $advice = AdviceRequest::with('farmer')->findOrFail($adviceRequest);
        
        // Check if agrovet is assigned or if it's unassigned
        if ($advice->assigned_agrovet_id !== null && $advice->assigned_agrovet_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.advice.show', compact('advice'));
    }

    public function respond(Request $request, $adviceRequest)
    {
        $advice = AdviceRequest::findOrFail($adviceRequest);
        
        // Check if agrovet is assigned or if it's unassigned
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

        return redirect()->route('agrovet.advice.show', $advice)
                         ->with('success', 'Response sent successfully to the farmer!');
    }
}