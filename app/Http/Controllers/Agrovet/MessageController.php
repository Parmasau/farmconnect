<?php
// app/Http/Controllers/Agrovet/MessageController.php

namespace App\Http\Controllers\Agrovet;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
                          ->orWhere('receiver_id', Auth::id())
                          ->with(['sender', 'receiver'])
                          ->orderBy('created_at', 'desc')
                          ->get()
                          ->unique(function($message) {
                              return $message->sender_id == Auth::id() ? $message->receiver_id : $message->sender_id;
                          });
        
        return view('agrovet.messages.index', compact('messages'));
    }

    public function show($farmerId)
    {
        $farmer = User::findOrFail($farmerId);
        
        $messages = Message::where(function($query) use ($farmerId) {
                                $query->where('sender_id', Auth::id())
                                      ->where('receiver_id', $farmerId);
                            })
                            ->orWhere(function($query) use ($farmerId) {
                                $query->where('sender_id', $farmerId)
                                      ->where('receiver_id', Auth::id());
                            })
                            ->with(['sender', 'receiver'])
                            ->orderBy('created_at', 'asc')
                            ->get();
        
        // Mark messages as read
        Message::where('sender_id', $farmerId)
              ->where('receiver_id', Auth::id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);
        
        return view('agrovet.messages.show', compact('farmer', 'messages'));
    }

    public function send(Request $request, $farmerId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $farmerId,
            'body' => $request->message,
            'read_at' => null,
        ]);
        
        return redirect()->route('agrovet.messages.show', $farmerId)
                         ->with('success', 'Message sent successfully!');
    }
}