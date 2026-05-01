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
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'business_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bio' => 'nullable|string|max:500',
        ];
        
        // Role-specific validation
        if ($user->isFarmer()) {
            $rules['phone'] = 'nullable|string|max:20';
            $rules['mpesa_number'] = 'nullable|string|max:20';
        }
        
        if ($user->isAgrovet()) {
            $rules['till_number'] = 'nullable|string|max:20';
        }
        
        $request->validate($rules);
        
        // Prepare data for update
        $data = $request->only(['name', 'email', 'business_name', 'address', 'bio']);
        
        if ($user->isFarmer()) {
            $data['phone'] = $request->phone;
            $data['mpesa_number'] = $request->mpesa_number;
        }
        
        if ($user->isAgrovet()) {
            $data['till_number'] = $request->till_number;
        }
        
        $user->update($data);

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