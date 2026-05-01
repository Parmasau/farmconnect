<?php
// app/Http/Controllers/MpesaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Models\Notification;

class MpesaController extends Controller
{
    // Simulate M-Pesa STK Push
    public function initiatePayment(Request $request)
    {
        $orderId = $request->order_id;
        $amount = $request->amount;
        $phoneNumber = $request->phone_number;
        
        // Get the logged-in user's M-Pesa number if not provided
        if (!$phoneNumber) {
            $phoneNumber = Auth::user()->mpesa_number;
        }
        
        // Format phone number (remove 0 at start, add 254)
        $phoneNumber = $this->formatPhoneNumber($phoneNumber);
        
        // Simulate STK Push
        $checkoutRequestID = 'WS_CO_' . time() . '_' . rand(1000, 9999);
        
        // Store in session the payment details
        session([
            'mpesa_payment' => [
                'order_id' => $orderId,
                'amount' => $amount,
                'phone' => $phoneNumber,
                'checkout_request_id' => $checkoutRequestID,
                'status' => 'pending'
            ]
        ]);
        
        // In a real implementation, you would call Safaricom API here
        // For now, simulate the API call
        return response()->json([
            'success' => true,
            'message' => 'STK Push sent to your phone',
            'checkout_request_id' => $checkoutRequestID,
            'phone' => $phoneNumber
        ]);
    }
    
    // Simulate M-Pesa callback (for simulation only)
    public function simulatePayment(Request $request)
    {
        $orderId = $request->order_id;
        $resultCode = $request->result_code ?? 0; // 0 = success
        
        $payment = session('mpesa_payment');
        
        if ($resultCode == 0) {
            // Payment successful
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
                
                // Notify the seller
                Notification::create([
                    'user_id' => $order->seller_id,
                    'title' => 'Payment Received',
                    'message' => 'Payment of KSh ' . number_format($order->total_amount, 2) . ' received for order #' . $order->order_number,
                    'type' => 'payment',
                    'data' => ['order_id' => $order->id],
                ]);
                
                // Notify the buyer
                Notification::create([
                    'user_id' => $order->buyer_id,
                    'title' => 'Payment Successful',
                    'message' => 'Your payment of KSh ' . number_format($order->total_amount, 2) . ' for order #' . $order->order_number . ' was successful',
                    'type' => 'payment',
                    'data' => ['order_id' => $order->id],
                ]);
            }
            
            session(['mpesa_payment' => null]);
            
            return response()->json([
                'success' => true,
                'message' => 'Payment successful!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.'
            ]);
        }
    }
    
    // Check payment status (polling)
    public function checkPaymentStatus(Request $request)
    {
        $payment = session('mpesa_payment');
        
        if ($payment && $payment['status'] == 'completed') {
            return response()->json([
                'completed' => true,
                'success' => true
            ]);
        }
        
        return response()->json([
            'completed' => false
        ]);
    }
    
    // Format phone number to international format
    private function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Remove leading 0 or 254 if present
        if (substr($phone, 0, 3) == '254') {
            $phone = substr($phone, 3);
        }
        if (substr($phone, 0, 1) == '0') {
            $phone = substr($phone, 1);
        }
        
        // Add 254 prefix
        return '254' . $phone;
    }
    
    // Verify M-Pesa Number
    public function verifyNumber(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string'
        ]);
        
        $phone = $this->formatPhoneNumber($request->phone_number);
        
        // Simulate verification (in real implementation, you'd call Safaricom API)
        // Check if number is valid (Safaricom numbers start with 2547...)
        if (preg_match('/^2547[0-9]{8}$/', $phone)) {
            return response()->json([
                'valid' => true,
                'message' => 'M-Pesa number verified',
                'formatted' => $phone
            ]);
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid M-Pesa number. Please enter a valid Safaricom number.'
            ]);
        }
    }
}