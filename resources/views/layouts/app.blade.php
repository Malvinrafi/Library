<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home User</title>
        @vite('resources/css/app.css', 'resources/js/app.js', 'resources/js/boostrap.js')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link rel="icon" href="C:\laragon\www\LIBRARY\public\images\libreria.png">
        <script>
            function searchBox() {
                return {
                    query: '',
                    show: false,
                    suggestions: ['Bookstore', 'Borrowed'],
                    get filteredSuggestions() {
                        return this.suggestions.filter(s => s.toLowerCase().includes(this.query.toLowerCase()));
                    },
                    updateSuggestions() {
                        this.show = this.query.length > 0;
                    },
                    selectSuggestion(suggestion) {
                        this.query = suggestion;
                        this.show = false;
                        this.navigateToPage();
                    },
                    handleEnter(event) {
                        if (event.key === 'Enter') {
                            this.navigateToPage();
                        }
                    },
                    navigateToPage() {
                        const target = this.query.toLowerCase();
                        if (target === 'bookstore') {
                            window.location.href = '/bookstore';
                        } else if (target === 'borrowed') {
                            window.location.href = '/borrowed';
                        } else {
                            window.location.href = '/'; // Tetap di Home
                        }
                    }
                };
            }
        </script>        
    </head>
    <body class="bg-gray-10" x-data="{ page: 'Home' }">
        <header class="bg-blue-300/70 backdrop-blur-md shadow-md text-black p-4 fixed top-0 left-0 w-full z-50">
            <div class="container mx-auto flex flex-wrap items-center justify-between gap-2">
                <div x-data="{ menuOpen: false }">
                    <button @click="menuOpen = !menuOpen" class="text-white text-lg font-bold focus:outline-none">
                        <span x-text="page"></span>
                    </button>
                    <div x-show="menuOpen" class="absolute left-0 bg-white mt-2 p-4 w-40 shadow-md rounded-md">
                        <a href="{{ route('home') }}" @click="page = 'Home'; menuOpen = false" class="block text-blue-400 py-2 hover:underline">Home</a>
                        <a href="{{route('bookstore')}}" @click="page = 'Bookstore'; menuOpen = false" class="block text-blue-400 py-2 hover:underline">Bookstore</a>
                        <a href="{{route('borrowed')}}" @click="page = 'Contact'; menuOpen = false" class="block text-blue-400 py-2 hover:underline">Borrowed</a>
                    </div>                
                </div>

                <div class="flex items-center gap-2">
                    <div class="w-auto" x-data="searchBox()">
                        <div class="relative">
                            <input 
                            type="text"
                            placeholder="Search..."
                            x-model="query"
                            @input="updateSuggestions"
                            @focus="show = true"
                            @click.outside="show = false"
                            @keydown.enter="handleEnter"
                            class="w-[100px] sm:w-[120px] md:w-[140px] lg:w-[160px] px-2 py-1 rounded text-black text-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300"
                            />                                                    
                            <ul 
                                x-show="show && filteredSuggestions.length" 
                                class="absolute bg-white border border-gray-300 w-full mt-1 rounded shadow z-50"
                            >
                                <template x-for="suggestion in filteredSuggestions" :key="suggestion">
                                    <li 
                                        @click="selectSuggestion(suggestion)" 
                                        class="px-4 py-2 hover:bg-blue-100 cursor-pointer text-slate-800"
                                        x-text="suggestion"
                                    ></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        @guest
                            <button class="bg-white text-blue-500 px-3 py-1 text-sm rounded" onclick="window.location.href='{{ route('login') }}'">
                                Login
                            </button>
                        @endguest

                        @auth
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="px-3 py-1 rounded bg-white text-blue-400 text-sm">
                                    {{ Auth::user()->name }}
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute bg-white text-black shadow-md rounded mt-1 p-2 w-40">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>
                
        <main class="container mx-auto mt-20 p-4 pb-10">
            @yield('content')
        </main>

        <footer class="text-center text-gray-600 p-4 mt-5">
            &copy; 2025 Home User. All Rights Reserved.
        </footer>
    </body>
</html>
