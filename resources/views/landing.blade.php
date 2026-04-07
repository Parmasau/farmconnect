@extends('layouts.app')

@section('title', 'FarmConnect — Connecting Farmers & Agrovets')

@section('content')
<!-- Navbar -->
<nav class="bg-green-800 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <a href="{{ route('landing') }}" class="text-2xl font-bold flex items-center gap-2">
                    🌱 FarmConnect
                </a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('landing') }}" class="hover:text-green-300 transition {{ request()->routeIs('landing') ? 'text-green-300 border-b-2 border-green-300' : '' }}">Home</a>
                    <a href="#about" class="hover:text-green-300 transition">About</a>
                    <a href="#contact" class="hover:text-green-300 transition">Contact</a>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="bg-transparent border border-white px-4 py-2 rounded-lg hover:bg-white hover:text-green-800 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-white text-green-800 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    Register
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="min-h-screen bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50">
        <div class="text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 animate-fade-in">Welcome to FarmConnect</h1>
            <p class="text-xl md:text-2xl mb-8">Connecting Farmers & Agrovets for a Sustainable Future</p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">About FarmConnect</h2>
            <div class="w-24 h-1 bg-green-600 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="text-5xl mb-4">🌾</div>
                <h3 class="text-xl font-semibold mb-2">For Farmers</h3>
                <p class="text-gray-600">Sell your produce directly to buyers, get expert advice, and connect with agrovets for quality inputs.</p>
            </div>
            <div class="text-center p-6">
                <div class="text-5xl mb-4">🔬</div>
                <h3 class="text-xl font-semibold mb-2">For Agrovets</h3>
                <p class="text-gray-600">Reach more farmers, offer quality products, and provide expert agricultural advice.</p>
            </div>
            <div class="text-center p-6">
                <div class="text-5xl mb-4">🤝</div>
                <h3 class="text-xl font-semibold mb-2">Direct Connection</h3>
                <p class="text-gray-600">Eliminate middlemen, get fair prices, and build lasting business relationships.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">Why Choose FarmConnect?</h2>
            <div class="w-24 h-1 bg-green-600 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
                <div class="text-4xl mb-3">💰</div>
                <h3 class="font-semibold mb-2">Best Prices</h3>
                <p class="text-sm text-gray-600">Get competitive prices for your farm products</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
                <div class="text-4xl mb-3">🚚</div>
                <h3 class="font-semibold mb-2">Easy Delivery</h3>
                <p class="text-sm text-gray-600">Connect with reliable transport services</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
                <div class="text-4xl mb-3">💡</div>
                <h3 class="font-semibold mb-2">Expert Advice</h3>
                <p class="text-sm text-gray-600">Get professional farming advice anytime</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition">
                <div class="text-4xl mb-3">🛡️</div>
                <h3 class="font-semibold mb-2">Secure Platform</h3>
                <p class="text-sm text-gray-600">Safe and secure transactions</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-green-800 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold mb-2">500+</div>
                <p class="text-green-200">Registered Farmers</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">100+</div>
                <p class="text-green-200">Agrovet Partners</p>
            </div>
            <div>
                <div class="text-4xl font-bold mb-2">1000+</div>
                <p class="text-green-200">Products Listed</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">Contact Us</h2>
            <div class="w-24 h-1 bg-green-600 mx-auto"></div>
            <p class="text-gray-600 mt-4">Have questions? We'd love to hear from you.</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Your Name</label>
                        <input type="text" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Enter your name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Enter your email">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea rows="4" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Your message"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                        Send Message
                    </button>
                </form>
            </div>
            
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="text-2xl">📍</div>
                    <div>
                        <h3 class="font-semibold">Visit Us</h3>
                        <p class="text-gray-600">Nairobi, Kenya</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="text-2xl">📞</div>
                    <div>
                        <h3 class="font-semibold">Call Us</h3>
                        <p class="text-gray-600">+254 700 000 000</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="text-2xl">✉️</div>
                    <div>
                        <h3 class="font-semibold">Email Us</h3>
                        <p class="text-gray-600">info@farmconnect.co.ke</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="text-2xl">🕒</div>
                    <div>
                        <h3 class="font-semibold">Working Hours</h3>
                        <p class="text-gray-600">Monday - Friday: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-green-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-3">FarmConnect</h3>
                <p class="text-green-300 text-sm">Connecting Farmers & Agrovets across Kenya</p>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-3">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('landing') }}" class="text-green-300 hover:text-white">Home</a></li>
                    <li><a href="#about" class="text-green-300 hover:text-white">About</a></li>
                    <li><a href="#contact" class="text-green-300 hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-3">Support</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-green-300 hover:text-white">Help Center</a></li>
                    <li><a href="#" class="text-green-300 hover:text-white">Terms of Service</a></li>
                    <li><a href="#" class="text-green-300 hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-lg mb-3">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-green-300 hover:text-white text-xl"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-green-300 hover:text-white text-xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-green-300 hover:text-white text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-green-300 hover:text-white text-xl"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-green-800 mt-8 pt-6 text-center text-sm text-green-300">
            <p>&copy; {{ date('Y') }} FarmConnect. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection