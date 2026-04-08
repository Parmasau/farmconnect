<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmConnect — Connecting Farmers & Agrovets</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-farm {
            background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        .bg-farm::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .bg-farm > * {
            position: relative;
            z-index: 1;
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        html {
            scroll-behavior: smooth;
        }
        .alert-success {
            transition: all 0.3s ease;
        }
        
        /* Active button styles */
        .btn-active {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Navigation link active state */
        .nav-link-active {
            border-bottom: 2px solid white;
            padding-bottom: 4px;
        }
        
        /* Smooth section highlighting */
        .section-highlight {
            transition: all 0.3s ease;
        }
        .section-highlight:target {
            background-color: rgba(22, 163, 74, 0.1);
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-farm min-h-screen">
    <!-- Navigation Bar for Landing Page -->
    <nav class="fixed top-0 left-0 right-0 bg-green-800/95 backdrop-blur-sm z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="#" class="text-white text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-seedling"></i> FarmConnect
                </a>
                <div class="hidden md:flex space-x-6">
                    <a href="#home" class="nav-link text-white hover:text-green-200 transition" data-section="home">Home</a>
                    <a href="#about" class="nav-link text-white hover:text-green-200 transition" data-section="about">About</a>
                    <a href="#features" class="nav-link text-white hover:text-green-200 transition" data-section="features">Features</a>
                    <a href="#stats" class="nav-link text-white hover:text-green-200 transition" data-section="stats">Stats</a>
                    <a href="#contact" class="nav-link text-white hover:text-green-200 transition" data-section="contact">Contact</a>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('login') }}" class="login-btn bg-transparent border border-white text-white px-4 py-2 rounded-lg hover:bg-white hover:text-green-800 transition">Login</a>
                    <a href="{{ route('register') }}" class="register-btn bg-white text-green-800 px-4 py-2 rounded-lg hover:bg-gray-100 transition">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center pt-16">
        <div class="text-center text-white px-4">
            <h1 class="text-5xl md:text-6xl font-bold mb-4 animate-fade-in">Welcome to FarmConnect</h1>
            <p class="text-xl md:text-2xl mb-8 animate-fade-in">Connecting Farmers & Agrovets for a Sustainable Future</p>
            <div class="flex gap-4 justify-center flex-wrap animate-fade-in">
                <button onclick="redirectToLogin()" class="login-hero-btn bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    Login
                </button>
                <button onclick="redirectToRegister()" class="register-hero-btn bg-white hover:bg-gray-100 text-green-700 px-8 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                    Register
                </button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white section-highlight">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">About FarmConnect</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 hover:shadow-lg transition rounded-xl">
                    <div class="text-5xl mb-4">🌾</div>
                    <h3 class="text-xl font-semibold mb-2">For Farmers</h3>
                    <p class="text-gray-600">Sell your produce directly to buyers, get expert advice, and connect with agrovets for quality inputs.</p>
                    <button onclick="redirectToRegister()" class="mt-4 text-green-600 hover:text-green-700 font-semibold">Join Now →</button>
                </div>
                <div class="text-center p-6 hover:shadow-lg transition rounded-xl">
                    <div class="text-5xl mb-4">🔬</div>
                    <h3 class="text-xl font-semibold mb-2">For Agrovets</h3>
                    <p class="text-gray-600">Reach more farmers, offer quality products, and provide expert agricultural advice.</p>
                    <button onclick="redirectToRegister()" class="mt-4 text-green-600 hover:text-green-700 font-semibold">Partner With Us →</button>
                </div>
                <div class="text-center p-6 hover:shadow-lg transition rounded-xl">
                    <div class="text-5xl mb-4">🤝</div>
                    <h3 class="text-xl font-semibold mb-2">Direct Connection</h3>
                    <p class="text-gray-600">Eliminate middlemen, get fair prices, and build lasting business relationships.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50 section-highlight">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">Why Choose FarmConnect?</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto"></div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="font-semibold mb-2">Best Prices</h3>
                    <p class="text-sm text-gray-600">Get competitive prices for your farm products</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-3">🚚</div>
                    <h3 class="font-semibold mb-2">Easy Delivery</h3>
                    <p class="text-sm text-gray-600">Connect with reliable transport services</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-3">💡</div>
                    <h3 class="font-semibold mb-2">Expert Advice</h3>
                    <p class="text-sm text-gray-600">Get professional farming advice anytime</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="text-4xl mb-3">🛡️</div>
                    <h3 class="font-semibold mb-2">Secure Platform</h3>
                    <p class="text-sm text-gray-600">Safe and secure transactions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-16 bg-green-800 text-white section-highlight">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="stat-card transform transition hover:scale-105">
                    <div class="text-4xl font-bold mb-2 counter">500</div>
                    <p class="text-green-200">Registered Farmers</p>
                </div>
                <div class="stat-card transform transition hover:scale-105">
                    <div class="text-4xl font-bold mb-2 counter">100</div>
                    <p class="text-green-200">Agrovet Partners</p>
                </div>
                <div class="stat-card transform transition hover:scale-105">
                    <div class="text-4xl font-bold mb-2 counter">1000</div>
                    <p class="text-green-200">Products Listed</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white section-highlight">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-4">Contact Us</h2>
                <div class="w-24 h-1 bg-green-600 mx-auto"></div>
                <p class="text-gray-600 mt-4">Have questions? We'd love to hear from you.</p>
            </div>

            @if(session('success'))
                <div class="max-w-2xl mx-auto mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="max-w-2xl mx-auto mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-gray-50 rounded-xl p-6">
                    <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Your Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Message *</label>
                            <textarea name="message" rows="4" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Your message" required>{{ old('message') }}</textarea>
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
                        <li><a href="#home" class="text-green-300 hover:text-white transition">Home</a></li>
                        <li><a href="#about" class="text-green-300 hover:text-white transition">About</a></li>
                        <li><a href="#features" class="text-green-300 hover:text-white transition">Features</a></li>
                        <li><a href="#contact" class="text-green-300 hover:text-white transition">Contact</a></li>
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
                        <a href="#" class="text-green-300 hover:text-white text-xl transition transform hover:scale-110"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-green-300 hover:text-white text-xl transition transform hover:scale-110"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-green-300 hover:text-white text-xl transition transform hover:scale-110"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-green-300 hover:text-white text-xl transition transform hover:scale-110"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-green-800 mt-8 pt-6 text-center text-sm text-green-300">
                <p>&copy; {{ date('Y') }} FarmConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }
        }, 5000);

        // Redirect functions
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }
        
        function redirectToRegister() {
            window.location.href = "{{ route('register') }}";
        }
        
        // Active navigation link highlighting
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link');
        
        function updateActiveLink() {
            let current = '';
            const scrollPosition = window.scrollY + 100;
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('border-b-2', 'border-white', 'pb-1');
                if (link.getAttribute('data-section') === current) {
                    link.classList.add('border-b-2', 'border-white', 'pb-1');
                }
            });
        }
        
        window.addEventListener('scroll', updateActiveLink);
        window.addEventListener('load', updateActiveLink);
        
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Counter animation for stats
        const counters = document.querySelectorAll('.counter');
        const speed = 200;
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.innerText);
            let count = 0;
            const increment = target / speed;
            
            const updateCount = () => {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };
        
        // Intersection Observer for counter animation
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    animateCounter(counter);
                    observer.unobserve(counter);
                }
            });
        }, observerOptions);
        
        counters.forEach(counter => {
            observer.observe(counter);
        });
        
        // Button active state styling
        const buttons = document.querySelectorAll('button, .login-btn, .register-btn, .login-hero-btn, .register-hero-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                this.classList.add('btn-active');
                setTimeout(() => {
                    this.classList.remove('btn-active');
                }, 200);
            });
        });
        
        // Form submission loading state
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            });
        }
    </script>
</body>
</html>