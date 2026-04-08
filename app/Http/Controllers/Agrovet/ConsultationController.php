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
                                    ->paginate(15);
        
        $stats = [
            'total' => Consultation::where('agrovet_id', Auth::id())->count(),
            'pending' => Consultation::where('agrovet_id', Auth::id())->where('status', 'requested')->count(),
            'accepted' => Consultation::where('agrovet_id', Auth::id())->where('status', 'confirmed')->count(),
            'in_progress' => Consultation::where('agrovet_id', Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Consultation::where('agrovet_id', Auth::id())->where('status', 'completed')->count(),
        ];
        
        return view('agrovet.consultations.index', compact('consultations', 'stats'));
    }

    public function pending()
    {
        $consultations = Consultation::where('agrovet_id', Auth::id())
                                    ->where('status', 'requested')
                                    ->with('farmer')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        
        $stats = [
            'total' => Consultation::where('agrovet_id', Auth::id())->count(),
            'pending' => Consultation::where('agrovet_id', Auth::id())->where('status', 'requested')->count(),
            'accepted' => Consultation::where('agrovet_id', Auth::id())->where('status', 'confirmed')->count(),
            'in_progress' => Consultation::where('agrovet_id', Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Consultation::where('agrovet_id', Auth::id())->where('status', 'completed')->count(),
        ];
        
        return view('agrovet.consultations.index', compact('consultations', 'stats'));
    }

    public function active()
    {
        $consultations = Consultation::where('agrovet_id', Auth::id())
                                    ->whereIn('status', ['confirmed', 'in_progress'])
                                    ->with('farmer')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        
        $stats = [
            'total' => Consultation::where('agrovet_id', Auth::id())->count(),
            'pending' => Consultation::where('agrovet_id', Auth::id())->where('status', 'requested')->count(),
            'accepted' => Consultation::where('agrovet_id', Auth::id())->where('status', 'confirmed')->count(),
            'in_progress' => Consultation::where('agrovet_id', Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Consultation::where('agrovet_id', Auth::id())->where('status', 'completed')->count(),
        ];
        
        return view('agrovet.consultations.index', compact('consultations', 'stats'));
    }

    public function completed()
    {
        $consultations = Consultation::where('agrovet_id', Auth::id())
                                    ->where('status', 'completed')
                                    ->with('farmer')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(15);
        
        $stats = [
            'total' => Consultation::where('agrovet_id', Auth::id())->count(),
            'pending' => Consultation::where('agrovet_id', Auth::id())->where('status', 'requested')->count(),
            'accepted' => Consultation::where('agrovet_id', Auth::id())->where('status', 'confirmed')->count(),
            'in_progress' => Consultation::where('agrovet_id', Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Consultation::where('agrovet_id', Auth::id())->where('status', 'completed')->count(),
        ];
        
        return view('agrovet.consultations.index', compact('consultations', 'stats'));
    }

    public function show(Consultation $consultation)
    {
        if ($consultation->agrovet_id !== Auth::id()) {
            abort(403);
        }
        
        return view('agrovet.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        if ($consultation->agrovet_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'status' => 'required|in:requested,confirmed,in_progress,completed,cancelled',
        ]);

        $oldStatus = $consultation->status;
        $consultation->update(['status' => $request->status]);
        
        // Create notification for farmer
        Notification::create([
            'user_id' => $consultation->farmer_id,
            'title' => 'Consultation Status Update',
            'message' => 'Your consultation "' . $consultation->topic . '" status has been updated from ' . $oldStatus . ' to ' . $request->status,
            'type' => 'consultation',
            'data' => ['consultation_id' => $consultation->id],
        ]);

        return redirect()->route('agrovet.consultations.show', $consultation)
                         ->with('success', 'Consultation status updated successfully!');
    }

    public function respond(Request $request, Consultation $consultation)
    {
        if ($consultation->agrovet_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'response' => 'required|string|min:10',
        ]);

        $consultation->update([
            'response' => $request->response,
            'responded_at' => now(),
        ]);

        // Create notification for farmer
        Notification::create([
            'user_id' => $consultation->farmer_id,
            'title' => 'New Response to Your Consultation',
            'message' => 'Agrovet has responded to your consultation "' . $consultation->topic . '"',
            'type' => 'consultation',
            'data' => ['consultation_id' => $consultation->id],
        ]);

        return redirect()->route('agrovet.consultations.show', $consultation)
                         ->with('success', 'Response sent successfully!');
    }
}