<?php
// app/Http/Controllers/Farmer/MessageController.php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Product;
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
        
        return view('farmer.messages.index', compact('messages'));
    }
    
    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        
        $messages = Message::where(function($query) use ($userId) {
                                $query->where('sender_id', Auth::id())
                                      ->where('receiver_id', $userId);
                            })
                            ->orWhere(function($query) use ($userId) {
                                $query->where('sender_id', $userId)
                                      ->where('receiver_id', Auth::id());
                            })
                            ->with(['sender', 'receiver'])
                            ->orderBy('created_at', 'asc')
                            ->get();
        
        // Update read status - using read_at instead of is_read
        Message::where('sender_id', $userId)
              ->where('receiver_id', Auth::id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);
        
        return view('farmer.messages.show', compact('otherUser', 'messages'));
    }
    
    public function send(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'content' => $request->message,
            'read_at' => null,
        ]);
        
        return redirect()->route('farmer.messages.show', $userId)
                         ->with('success', 'Message sent successfully!');
    }
    
    public function create(Request $request)
    {
        $farmerId = $request->get('farmer_id');
        $productId = $request->get('product_id');
        
        if ($farmerId) {
            $receiver = User::findOrFail($farmerId);
        } else {
            $receiver = null;
        }
        
        $product = null;
        if ($productId) {
            $product = Product::find($productId);
        }
        
        return view('farmer.messages.create', compact('receiver', 'product'));
    }
    
    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
                       ->whereNull('read_at')
                       ->count();
        
        return response()->json(['count' => $count]);
    }
}