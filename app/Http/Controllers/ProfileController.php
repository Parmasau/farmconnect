<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'business_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bio' => 'nullable|string|max:500',
        ]);

        // Only update fields that exist
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Add optional fields if they exist in request
        if ($request->has('phone')) {
            $updateData['phone'] = $request->phone;
        }
        if ($request->has('business_name')) {
            $updateData['business_name'] = $request->business_name;
        }
        if ($request->has('address')) {
            $updateData['address'] = $request->address;
        }
        if ($request->has('bio')) {
            $updateData['bio'] = $request->bio;
        }

        $user->update($updateData);

        return redirect()->route('profile.edit')
                         ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => 'required',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')
                         ->with('success', 'Password changed successfully!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}