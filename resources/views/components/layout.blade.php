<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    <!-- CDN for SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Scripts -->

    

</head>

<body class="bg-gray-100 text-gray-800">
    <header class="bg-gray-900 shadow-lg">
        <nav class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="{{ route('posts.index') }}" class="text-white font-semibold text-lg">Home</a>

            @auth
                <div class="relative" x-data="{ open: false }">
                    <!-- Profile Button -->
                    <button type="button" class="flex items-center space-x-2 rounded-full focus:outline-none" x-on:click="open = !open">
                        <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://picsum.photos/200/300" alt="{{ auth()->user()->name }}">
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden transition-all transform origin-top-right"
                        x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 scale-90"
                        x-on:click.away="open = false">
                        
                        <div class="p-4 border-b">
                            <p class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</p>
                           
                        </div>
                       
                        
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Dashboard
                        </a>
                        
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-gray-300">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Register</a>
                </div>
            @endguest
        </nav>
    </header>

    <main class="py-8 px-6 mx-auto max-w-7xl">
        {{ $slot }}
    </main>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("formSubmit", () => ({
                submit() {
                    this.$refs.btn.disabled = true;
                    this.$refs.btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    this.$refs.btn.classList.add('bg-indigo-400', 'cursor-not-allowed');
                    this.$refs.btn.innerHTML = `
                        <span class="inline-block animate-spin">
                            <i class="fa-solid fa-spinner"></i>
                        </span> Processing...`;
                    
                    this.$el.submit();
                }
            }));
        });
        
    </script>
</body>
</html>
