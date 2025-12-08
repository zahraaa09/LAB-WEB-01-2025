<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Product Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('products.index') }}" class="text-xl font-bold hover:text-blue-200 transition">
                    📦 Product Management
                </a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('products.index') }}" 
                       class="hover:text-blue-200 transition {{ request()->routeIs('products.*') ? 'border-b-2 border-white' : '' }}">
                        Products
                    </a>
                    <a href="{{ route('categories.index') }}" 
                       class="hover:text-blue-200 transition {{ request()->routeIs('categories.*') ? 'border-b-2 border-white' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('warehouses.index') }}" 
                       class="hover:text-blue-200 transition {{ request()->routeIs('warehouses.*') ? 'border-b-2 border-white' : '' }}">
                        Warehouses
                    </a>
                    <a href="{{ route('stocks.index') }}" 
                       class="hover:text-blue-200 transition {{ request()->routeIs('stocks.*') ? 'border-b-2 border-white' : '' }}">
                        Stock Management
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 flex-1">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">✓ {{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">✗ {{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">Validation Error!</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Product Management System. Tugas Praktikum 9.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>