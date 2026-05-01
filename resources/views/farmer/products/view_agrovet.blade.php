{{-- resources/views/farmer/products/view_agrovet.blade.php --}}
@extends('layouts.dashboard')

@section('title', $product->name . ' - Product Details')

@section('sidebar')
    @include('farmer.sidebar')
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img src="{{ $product->image_url }}" class="w-full h-96 object-cover" alt="{{ $product->name }}">
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-green-700 mb-4">KSh {{ number_format($product->price, 2) }}</p>
                
                <!-- Seller Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-store text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $product->seller->name ?? 'Agrovet' }}</p>
                            <p class="text-sm text-gray-500">Agrovet Seller</p>
                        </div>
                        <a href="{{ route('farmer.messages.create', ['farmer_id' => $product->user_id, 'product_id' => $product->id]) }}" 
                           class="ml-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                            <i class="fas fa-envelope"></i> Message Seller
                        </a>
                    </div>
                </div>
                
                <!-- Product Details -->
                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <h3 class="font-semibold mb-1">Category</h3>
                        <p class="text-gray-600">{{ ucfirst($product->category) }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-1">Stock</h3>
                        <p class="text-gray-600">{{ $product->quantity }} {{ $product->unit }}</p>
                    </div>
                </div>
                
                <!-- Buy Now Form -->
                @if($product->quantity > 0)
                <div class="border-t pt-4 mt-4">
                    <h3 class="font-semibold mb-3">Buy Now</h3>
                    <form action="{{ route('order.create', $product) }}" method="POST" id="buyForm">
                        @csrf
                        <div class="flex gap-3 mb-3">
                            <div class="flex-1">
                                <label class="block text-sm text-gray-600 mb-1">Quantity ({{ $product->unit }})</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}" 
                                       class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm text-gray-600 mb-1">Total Price</label>
                                <input type="text" id="totalPrice" value="KSh {{ number_format($product->price, 2) }}" 
                                       class="w-full border rounded-lg px-3 py-2 bg-gray-50" readonly>
                            </div>
                        </div>
                        <button type="button" onclick="showPaymentModal()" 
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-semibold transition">
                            <i class="fas fa-shopping-cart"></i> Buy Now
                        </button>
                    </form>
                </div>
                @else
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4">
                    <i class="fas fa-exclamation-circle"></i> Out of Stock
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Seller's Other Products -->
    @if(isset($sellerProducts) && $sellerProducts->count() > 0)
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">More from {{ $product->seller->name ?? 'this agrovet' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($sellerProducts as $sellerProduct)
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                <img src="{{ $sellerProduct->image_url }}" class="w-full h-32 object-cover" alt="{{ $sellerProduct->name }}">
                <div class="p-3">
                    <h3 class="font-semibold text-sm">{{ $sellerProduct->name }}</h3>
                    <p class="text-green-700 font-bold text-sm">KSh {{ number_format($sellerProduct->price, 2) }}</p>
                    <a href="{{ route('farmer.products.viewAgrovet', $sellerProduct->id) }}" class="text-blue-600 text-xs hover:underline">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Complete Payment</h3>
                <button onclick="hidePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="bg-green-50 rounded-lg p-4 mb-4">
                <div class="flex justify-between mb-2">
                    <span>Product:</span>
                    <span class="font-semibold">{{ $product->name }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Quantity:</span>
                    <span class="font-semibold" id="modalQuantity">1</span>
                </div>
                <div class="flex justify-between pt-2 border-t">
                    <span class="font-bold">Total:</span>
                    <span class="font-bold text-green-700 text-lg" id="modalTotal">KSh {{ number_format($product->price, 2) }}</span>
                </div>
            </div>
            
            <!-- M-Pesa Number Section (Till Number) -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">M-Pesa Till Number *</label>
                <div class="flex gap-2">
                    <input type="tel" id="mpesaNumber" placeholder="Enter M-Pesa Till Number" 
                           class="flex-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500"
                           value="{{ auth()->user()->mpesa_number ?? '' }}">
                    <button type="button" onclick="verifyMpesaNumber()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Verify
                    </button>
                </div>
                <div id="verificationMessage" class="text-xs mt-1 hidden"></div>
                <p class="text-xs text-gray-500 mt-1">Enter your M-Pesa Till Number or PayBill number</p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="hidePaymentModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                <button onclick="processMpesaPayment()" id="payNowBtn" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700" disabled>
                    Pay Now
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-mobile-alt text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold">Confirm M-Pesa Payment</h3>
                <p class="text-gray-600 text-sm mt-1">Confirm your payment details</p>
            </div>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex justify-between mb-2">
                    <span>Amount:</span>
                    <span class="font-bold text-green-700" id="confirmAmount">KSh 0</span>
                </div>
                <div class="flex justify-between">
                    <span>Till/PayBill:</span>
                    <span class="font-semibold" id="confirmPhone"></span>
                </div>
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    After payment, your order will be confirmed automatically. Please keep your M-Pesa transaction ID for reference.
                </p>
            </div>
            
            <div class="flex gap-3">
                <button onclick="hideConfirmationModal()" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                <button onclick="sendPaymentRequest()" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Confirm Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Processing Modal -->
<div id="processingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full mx-4 p-6 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"></div>
        <p class="text-gray-700 font-semibold">Processing Payment</p>
        <p class="text-sm text-gray-500 mt-2">Please complete the payment on your M-Pesa</p>
        <p class="text-xs text-gray-400 mt-4" id="processingTimer">Waiting for confirmation...</p>
    </div>
</div>

<script>
    let verifiedMpesaNumber = null;
    let currentOrderId = null;
    let paymentCheckInterval = null;
    
    // Update total price when quantity changes
    const quantityInput = document.getElementById('quantity');
    const totalPriceInput = document.getElementById('totalPrice');
    const productPrice = {{ $product->price }};
    
    if (quantityInput) {
        quantityInput.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 0;
            const total = quantity * productPrice;
            totalPriceInput.value = 'KSh ' + total.toLocaleString();
        });
    }
    
    function showPaymentModal() {
        const quantity = document.getElementById('quantity').value;
        const total = quantity * productPrice;
        
        document.getElementById('modalQuantity').textContent = quantity;
        document.getElementById('modalTotal').textContent = 'KSh ' + total.toLocaleString();
        document.getElementById('paymentModal').classList.remove('hidden');
        document.getElementById('paymentModal').classList.add('flex');
        
        // Reset verification
        verifiedMpesaNumber = null;
        document.getElementById('payNowBtn').disabled = true;
        document.getElementById('mpesaNumber').value = '';
        document.getElementById('verificationMessage').classList.add('hidden');
    }
    
    function hidePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.getElementById('paymentModal').classList.remove('flex');
    }
    
    function hideConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        document.getElementById('confirmationModal').classList.remove('flex');
        showPaymentModal();
    }
    
    function verifyMpesaNumber() {
        const mpesaNumber = document.getElementById('mpesaNumber').value;
        const verificationMsg = document.getElementById('verificationMessage');
        
        if (!mpesaNumber) {
            verificationMsg.textContent = 'Please enter your M-Pesa Till/PayBill number';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
            return;
        }
        
        // Validate that it's a number
        const cleanNumber = mpesaNumber.replace(/[^0-9]/g, '');
        
        if (cleanNumber.length >= 6 && cleanNumber.length <= 12) {
            verifiedMpesaNumber = cleanNumber;
            verificationMsg.textContent = '✓ M-Pesa number verified';
            verificationMsg.className = 'text-xs mt-1 text-green-600';
            verificationMsg.classList.remove('hidden');
            document.getElementById('payNowBtn').disabled = false;
        } else {
            verificationMsg.textContent = 'Invalid number. Please enter a valid M-Pesa Till/PayBill number';
            verificationMsg.className = 'text-xs mt-1 text-red-600';
            verificationMsg.classList.remove('hidden');
            document.getElementById('payNowBtn').disabled = true;
        }
    }
    
    function processMpesaPayment() {
        const quantity = document.getElementById('quantity').value;
        const total = quantity * productPrice;
        const tillNumber = document.getElementById('mpesaNumber').value;
        
        document.getElementById('confirmAmount').textContent = 'KSh ' + total.toLocaleString();
        document.getElementById('confirmPhone').textContent = tillNumber;
        
        hidePaymentModal();
        document.getElementById('confirmationModal').classList.remove('hidden');
        document.getElementById('confirmationModal').classList.add('flex');
    }
    
    function sendPaymentRequest() {
        hideConfirmationModal();
        
        const quantity = document.getElementById('quantity').value;
        const total = quantity * productPrice;
        const tillNumber = document.getElementById('mpesaNumber').value;
        
        // Show processing modal
        document.getElementById('processingModal').classList.remove('hidden');
        document.getElementById('processingModal').classList.add('flex');
        
        // Start timer display
        let seconds = 0;
        const timer = setInterval(() => {
            seconds++;
            document.getElementById('processingTimer').textContent = `Waiting for confirmation... (${seconds}s)`;
        }, 1000);
        
        // Create order via AJAX
        const form = document.getElementById('buyForm');
        const formData = new FormData(form);
        formData.append('payment_method', 'mpesa');
        formData.append('mpesa_number', tillNumber);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentOrderId = data.order_id;
                
                // Store payment info
                return fetch('/mpesa/initiate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: currentOrderId,
                        amount: total,
                        phone_number: null, // No phone number for till payments
                        till_number: verifiedMpesaNumber
                    })
                });
            } else {
                throw new Error(data.message || 'Order creation failed');
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Poll for payment status
                let attempts = 0;
                paymentCheckInterval = setInterval(() => {
                    attempts++;
                    fetch('/mpesa/status/' + currentOrderId, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(status => {
                        if (status.completed) {
                            clearInterval(paymentCheckInterval);
                            clearInterval(timer);
                            document.getElementById('processingModal').classList.add('hidden');
                            alert('Payment successful! Order placed successfully.');
                            window.location.href = '{{ route("farmer.orders.index") }}';
                        } else if (attempts > 60) {
                            clearInterval(paymentCheckInterval);
                            clearInterval(timer);
                            document.getElementById('processingModal').classList.add('hidden');
                            alert('Payment timeout. Please check your order status later.');
                            window.location.href = '{{ route("farmer.orders.index") }}';
                        }
                    });
                }, 2000);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            clearInterval(timer);
            document.getElementById('processingModal').classList.add('hidden');
            alert('Payment initiation failed: ' + error.message);
        });
    }
    
    // Close modals when clicking outside
    document.getElementById('paymentModal')?.addEventListener('click', function(e) {
        if (e.target === this) hidePaymentModal();
    });
    
    document.getElementById('confirmationModal')?.addEventListener('click', function(e) {
        if (e.target === this) hideConfirmationModal();
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hidePaymentModal();
            hideConfirmationModal();
        }
    });
</script>
@endsection