<nav class="bg-gray-900 border-b border-gray-800" x-data="{ isOpen: false, isProfileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            
            <div class="flex items-center">
                <a href="/" class="shrink-0 flex items-center gap-3 group">
                    <img class="h-10 w-10 transition-transform duration-300 group-hover:scale-110 rounded-full shadow-lg ring-2 ring-indigo-500/50" 
                         src="{{ asset('img/logo.png') }}" 
                         alt="Logo NIVRA02">
                    <span class="text-xl font-bold tracking-wider text-white group-hover:text-indigo-400 transition-colors">
                        NIVRA02
                    </span>
                </a>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-2">
                        <a href="/" class="{{ request()->is('/') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all">Home</a>
                        <a href="/developer" class="{{ request()->is('developer') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all">Developer</a>
                        <a href="/Chatbot" class="{{ request()->is('Chatbot') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium transition-all">AI Chatbot</a>
                        
                        @auth
                            @if(Auth::user()->is_admin)
                                <a href="/admin/upload" class="{{ request()->is('admin/upload') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-gray-300 hover:bg-indigo-500/20 hover:text-indigo-300' }} ml-4 rounded-md px-3 py-2 text-sm font-bold transition-all border border-transparent hover:border-indigo-500/50">
                                    Upload Game
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    
                    <a href="{{ route('games.random') }}" 
                       class="group relative mr-6 inline-flex items-center justify-center overflow-hidden rounded-lg bg-gray-900 px-4 py-2 text-sm font-bold text-white shadow transition-all duration-300 hover:scale-105 hover:shadow-indigo-500/50 border border-indigo-500/30">
                        <span class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 opacity-80 transition-opacity duration-300 group-hover:opacity-100"></span>
                        <span class="absolute top-0 -left-[100%] h-full w-full rotate-12 scale-[2] transform bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-700 group-hover:left-[100%]"></span>
                        <span class="relative flex items-center">
                            <svg class="mr-2 h-5 w-5 transition-transform group-hover:rotate-180 duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Surprise Me!
                        </span>
                    </a>

                    @guest
                        <a href="/login" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium transition-all">Log in</a>
                        <a href="/register" class="ml-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-indigo-500 shadow-lg shadow-indigo-500/30 transition-all hover:scale-105">Register</a>
                    @endguest

                    @auth
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isProfileOpen = !isProfileOpen" @click.away="isProfileOpen = false" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all hover:ring-offset-gray-800">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full border-2 border-indigo-500/70" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="">
                                </button>
                            </div>
                            <div x-show="isProfileOpen" x-transition class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-gray-800 py-1 shadow-xl ring-1 ring-black/5 border border-gray-700 focus:outline-none" style="display: none;">
                                <div class="border-b border-gray-700 px-4 py-3 text-sm">
                                    <div class="text-gray-400">Login sebagai:</div>
                                    <div class="font-bold text-indigo-400 truncate">{{ Auth::user()->name }}</div>
                                </div>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors rounded-b-xl">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
            
            <div class="-mr-2 flex md:hidden">
                <button type="button" @click="isOpen = !isOpen" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isOpen" class="md:hidden border-t border-gray-800" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Home</a>
            <a href="/developer" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Developer</a>
            <a href="/Chatbot" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">AI Chatbot</a>

            <a href="{{ route('games.random') }}" class="relative overflow-hidden block rounded-md bg-gradient-to-r from-indigo-600 to-purple-600 px-3 py-2 text-base font-bold text-white hover:from-indigo-500 hover:to-purple-500 shadow-lg shadow-indigo-500/20 flex items-center justify-center mt-2 group">
                 <svg class="mr-2 h-5 w-5 transition-transform group-hover:rotate-180 duration-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Surprise Me!
            </a>

            @auth
                @if(Auth::user()->is_admin)
                    <a href="/admin/upload" class="block rounded-md bg-indigo-900/30 px-3 py-2 text-base font-bold text-indigo-300 hover:bg-indigo-900/50 hover:text-white border border-indigo-500/30 mt-2 text-center">
                        Upload Game
                    </a>
                @endif
            @endauth
        </div>
        
        <div class="border-t border-gray-800 pb-3 pt-4">
            @auth
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="h-10 w-10 rounded-full border-2 border-indigo-500" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium leading-none text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="block w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign out</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="mt-3 space-y-1 px-2">
                    <a href="/login" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Log in</a>
                    <a href="/register" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Register</a>
                </div>
            @endguest
        </div>
    </div>
</nav>