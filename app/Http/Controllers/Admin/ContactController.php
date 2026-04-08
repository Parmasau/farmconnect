<?php
// app/Http/Controllers/Admin/ContactController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = ContactMessage::where('is_read', false)->count();
        
        return view('admin.contact.index', compact('messages', 'unreadCount'));
    }
    
    public function show(ContactMessage $message)
    {
        if (!$message->is_read) {
            $message->markAsRead();
        }
        
        return view('admin.contact.show', compact('message'));
    }
    
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.contact.index')
                         ->with('success', 'Message deleted successfully!');
    }
}