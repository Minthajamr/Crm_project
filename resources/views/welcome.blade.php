<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }
        
        .grid-bg {
            background-image: 
                linear-gradient(to right, #e5e7eb 1px, transparent 1px),
                linear-gradient(to bottom, #e5e7eb 1px, transparent 1px);
            background-size: 40px 40px;
        }
        
        .spotlight {
            background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-gray-50 grid-bg">
    <!-- Navigation -->
    <nav class="absolute top-0 w-full z-10">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="text-2xl font-bold text-gray-900">CRM</div>
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                            Get Started
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="spotlight min-h-screen flex items-center justify-center px-6">
        <div class="max-w-5xl mx-auto text-center pt-20">
            <!-- Badge -->
            <div class="fade-in inline-flex items-center px-4 py-2 bg-indigo-50 rounded-full mb-8">
                <span class="w-2 h-2 bg-indigo-600 rounded-full mr-2 animate-pulse"></span>
                <span class="text-sm text-indigo-600 font-semibold">Built for Modern Teams</span>
            </div>

            <!-- Main Heading -->
            <h1 class="fade-in delay-1 text-6xl md:text-7xl lg:text-8xl font-bold text-gray-900 mb-6 leading-tight">
                Customer Relations<br/>
                <span class="text-indigo-600">Simplified</span>
            </h1>

            <!-- Subheading -->
            <p class="fade-in delay-2 text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Manage your customer relationships with elegance and efficiency. 
                Everything you need, nothing you don't.
            </p>

            <!-- CTA Buttons -->
            <div class="fade-in delay-3 flex flex-col sm:flex-row gap-4 justify-center mb-16">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="px-8 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Open Dashboard →
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-8 py-4 bg-indigo-600 text-white text-lg font-semibold rounded-lg hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Login →
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="px-8 py-4 bg-white text-gray-900 text-lg font-semibold rounded-lg hover:bg-gray-50 transition border-2 border-gray-200 transform hover:-translate-y-0.5">
                            Create Account
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Stats -->
            <div class="fade-in delay-3 grid grid-cols-3 gap-8 max-w-3xl mx-auto pt-12 border-t border-gray-200">
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">99.9%</div>
                    <div class="text-sm text-gray-600">Uptime</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">10k+</div>
                    <div class="text-sm text-gray-600">Active Users</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">Fast</div>
                    <div class="text-sm text-gray-600">Performance</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full py-6">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-500">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} • PHP v{{ PHP_VERSION }}
            </p>
        </div>
    </footer>
</body>
</html>