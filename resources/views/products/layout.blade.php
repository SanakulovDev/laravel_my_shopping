<!DOCTYPE html>
<html>
<head>
    <title>Laravel 12 CRUD Application - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>
    </header>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-6">
                <h2 class="text-lg font-semibold">Sidebar</h2>
                <ul class="mt-6">
                    <li class="mt-3">
                        <a href="{{ url('products') }}" class="block text-gray-300 hover:text-white {{ request()->is('products') ? 'text-white font-bold' : '' }}">Products</a>
                    </li>
                    <li class="mt-3">
                        <a href="{{ url('categories') }}" class="block text-gray-300 hover:text-white {{ request()->is('categories') ? 'text-white font-bold' : '' }}">Categories</a>
                    </li>
                    <li class="mt-3">
                        <a href="{{ url('users') }}" class="block text-gray-300 hover:text-white {{ request()->is('users') ? 'text-white font-bold' : '' }}">Users</a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow mt-6">
        <div class="container mx-auto px-4 py-6">
            <p class="text-gray-600">&copy; 2023 ItSolutionStuff.com. All rights reserved.</p>
        </div>
    </footer>
</div>

</body>
</html>