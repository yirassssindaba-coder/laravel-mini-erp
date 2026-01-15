<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ERP Mini') - ERP Mini</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <div x-cloak 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-700 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-between h-16 px-6 bg-indigo-800">
                <span class="text-xl font-bold text-white">ERP Mini</span>
                <button @click="sidebarOpen = false" class="lg:hidden text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 text-gray-200 hover:bg-indigo-600 {{ request()->routeIs('dashboard') ? 'bg-indigo-600' : '' }}">
                    <i class="fas fa-tachometer-alt w-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center px-6 py-3 text-gray-200 hover:bg-indigo-600 {{ request()->routeIs('products.*') ? 'bg-indigo-600' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span class="ml-3">Produk</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center px-6 py-3 text-gray-200 hover:bg-indigo-600 {{ request()->routeIs('inventory.*') ? 'bg-indigo-600' : '' }}">
                    <i class="fas fa-warehouse w-5"></i>
                    <span class="ml-3">Inventori</span>
                </a>
                <a href="{{ route('orders.index') }}" class="flex items-center px-6 py-3 text-gray-200 hover:bg-indigo-600 {{ request()->routeIs('orders.*') ? 'bg-indigo-600' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span class="ml-3">Order</span>
                </a>
                <a href="{{ route('marketplace.index') }}" class="flex items-center px-6 py-3 text-gray-200 hover:bg-indigo-600 {{ request()->routeIs('marketplace.*') ? 'bg-indigo-600' : '' }}">
                    <i class="fas fa-store w-5"></i>
                    <span class="ml-3">Marketplace</span>
                </a>
            </nav>
        </div>

        <div x-cloak @click="sidebarOpen = false" x-show="sidebarOpen" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <div class="text-sm text-gray-500">{{ now()->format('d M Y') }}</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
