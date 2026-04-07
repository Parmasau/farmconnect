<?php
// app/Http/Controllers/Agrovet/ConsultationController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::where('agrovet_id', Auth::id())
                                    ->with('farmer')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10);
        
        $stats = [
            'pending' => Consultation::where('agrovet_id', Auth::id())->where('status', 'pending')->count(),
            'accepted' => Consultation::where('agrovet_id', Auth::id())->where('status', 'accepted')->count(),
            'in_progress' => Consultation::where('agrovet_id', Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Consultation::where('agrovet_id', Auth::id())->where('status', 'completed')->count(),
        ];
        
        return view('agrovet.consultations.index', compact('consultations', 'stats'));
    }

    public function show(Consultation $consultation)
    {
        abort_if($consultation->agrovet_id !== Auth::id(), 403);
        
        return view('agrovet.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        abort_if($consultation->agrovet_id !== Auth::id(), 403);
        
        $request->validate([
            'status' => 'required|in:accepted,in_progress,completed,cancelled',
            'response' => 'nullable|string',
        ]);
        
        $consultation->update([
            'status' => $request->status,
            'response' => $request->response,
            'responded_at' => now(),
        ]);
        
        // Create notification for farmer
        Notification::create([
            'user_id' => $consultation->farmer_id,
            'title' => 'Consultation Update',
            'message' => 'Your consultation "' . $consultation->topic . '" has been ' . $request->status,
            'type' => 'consultation',
            'data' => ['consultation_id' => $consultation->id],
        ]);
        
        return back()->with('success', 'Consultation status updated successfully!');
    }
}