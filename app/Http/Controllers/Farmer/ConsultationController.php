<?php
// app/Http/Controllers/Farmer/ConsultationController.php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::where('farmer_id', Auth::id())
                                    ->with('agrovet')
                                    ->latest()
                                    ->paginate(10);
        
        return view('farmer.consultations.index', compact('consultations'));
    }

    public function create()
    {
        $agrovets = User::where('role', 'agrovet')->where('is_active', true)->get();
        return view('farmer.consultations.create', compact('agrovets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agrovet_id' => 'required|exists:users,id',
            'topic' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:chat,video,phone,in_person',
            'scheduled_at' => 'nullable|date',
        ]);

        $consultation = Consultation::create([
            'farmer_id' => Auth::id(),
            'agrovet_id' => $request->agrovet_id,
            'topic' => $request->topic,
            'description' => $request->description,
            'type' => $request->type,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'requested', // Change from 'pending' to 'requested'
        ]);

        return redirect()->route('farmer.consultations.index')
                         ->with('success', 'Consultation request sent successfully!');
    }

    public function show(Consultation $consultation)
    {
        abort_if($consultation->farmer_id !== Auth::id(), 403);
        
        return view('farmer.consultations.show', compact('consultation'));
    }

    public function cancel(Consultation $consultation)
    {
        abort_if($consultation->farmer_id !== Auth::id(), 403);
        
        $consultation->update(['status' => 'cancelled']);
        
        return redirect()->route('farmer.consultations.index')
                         ->with('success', 'Consultation cancelled successfully.');
    }
}