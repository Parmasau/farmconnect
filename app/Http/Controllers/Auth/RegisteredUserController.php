<?php
// app/Http/Controllers/Auth/RegisteredUserController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:farmer,agrovet,admin'],
        ];
        
        // Role-specific validation
        if ($request->role === 'farmer') {
            $rules['phone'] = ['nullable', 'string', 'max:20'];
            $rules['mpesa_number'] = ['required', 'string', 'max:20'];
        }
        
        if ($request->role === 'agrovet') {
            $rules['business_name'] = ['required', 'string', 'max:255'];
            $rules['till_number'] = ['required', 'string', 'max:20'];
        }
        
        if ($request->role === 'admin') {
            $rules['phone'] = ['nullable', 'string', 'max:20'];
        }
        
        $request->validate($rules);
        
        // Prepare user data
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];
        
        // Add role-specific data
        if ($request->role === 'farmer') {
            $userData['phone'] = $request->phone;
            $userData['mpesa_number'] = $request->mpesa_number;
        }
        
        if ($request->role === 'agrovet') {
            $userData['business_name'] = $request->business_name;
            $userData['till_number'] = $request->till_number;
        }
        
        if ($request->role === 'admin') {
            $userData['phone'] = $request->phone;
        }
        
        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'agrovet') {
            return redirect()->route('agrovet.dashboard');
        } else {
            return redirect()->route('farmer.dashboard');
        }
    }
}