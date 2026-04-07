<?php

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
        $userId = Auth::id();
        $conversations = Message::with(['sender', 'receiver'])
            ->where('sender_id', $userId)->orWhere('receiver_id', $userId)
            ->latest()->get()
            ->groupBy(fn($m) => $m->sender_id === $userId ? $m->receiver_id : $m->sender_id)
            ->map(fn($msgs) => $msgs->first());

        return view('agrovet.messages.index', compact('conversations'));
    }

    public function show(User $farmer)
    {
        $userId = Auth::id();
        $messages = Message::where(fn($q) => $q->where('sender_id', $userId)->where('receiver_id', $farmer->id))
            ->orWhere(fn($q) => $q->where('sender_id', $farmer->id)->where('receiver_id', $userId))
            ->orderBy('created_at')->get();

        $messages->each(fn($m) => $m->receiver_id === $userId ? $m->markRead() : null);

        return view('agrovet.messages.show', compact('farmer', 'messages'));
    }

    public function send(Request $request, User $farmer)
    {
        $request->validate(['body' => 'required|string|max:1000']);
        Message::create(['sender_id' => Auth::id(), 'receiver_id' => $farmer->id, 'body' => $request->body]);
        return back()->with('success', 'Message sent.');
    }
}
