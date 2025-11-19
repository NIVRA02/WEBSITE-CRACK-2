<nav class="bg-gray-800" x-data="{ isOpen: false, isProfileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            
            <div class="flex items-center">
                <a href="/" class="shrink-0 flex items-center gap-3 group">
                    <img class="h-9 w-9 transition-transform duration-300 group-hover:scale-110" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Logo">
                    <span class="text-xl font-bold tracking-wider text-white group-hover:text-indigo-400 transition-colors">
                        NIVRA02
                    </span>
                </a>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Home</a>
                        <a href="/developer" class="{{ request()->is('developer') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Developer</a>
                        <a href="/Chatbot" class="{{ request()->is('Chatbot') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Chatbot</a>
                        <a href="/contact" class="{{ request()->is('contact') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium">Contact Us</a>

                        @auth
                            @if(Auth::user()->is_admin)
                                <a href="/admin/upload" class="{{ request()->is('admin/upload') ? 'bg-indigo-600 text-white shadow-lg' : 'text-gray-300 hover:bg-indigo-500/20 hover:text-indigo-300' }} ml-4 rounded-md px-3 py-2 text-sm font-bold transition-all">
                                    Upload Game
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    @guest
                        <a href="/login" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Log in</a>
                        <a href="/register" class="ml-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-500 shadow-md transition-transform hover:scale-105">Register</a>
                    @endguest

                    @auth
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isProfileOpen = !isProfileOpen" @click.away="isProfileOpen = false" class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full border-2 border-indigo-500" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="">
                                </button>
                            </div>

                            <div x-show="isProfileOpen" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none" style="display: none;">
                                
                                <div class="border-b px-4 py-2 text-xs text-gray-500">
                                    Halo, <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span>
                                </div>
                                
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
            
            <div class="-mr-2 flex md:hidden">
                <button type="button" @click="isOpen = !isOpen" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{'hidden': isOpen, 'block': !isOpen }" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    <svg :class="{'block': isOpen, 'hidden': !isOpen }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/" class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Home</a>
            <a href="/developer" class="{{ request()->is('developer') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Developer</a>
            <a href="/Chatbot" class="{{ request()->is('Chatbot') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Chatbot</a>
            <a href="/contact" class="{{ request()->is('contact') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} block rounded-md px-3 py-2 text-base font-medium">Contact Us</a>

            @auth
                @if(Auth::user()->is_admin)
                    <a href="/admin/upload" class="block rounded-md bg-indigo-900/50 px-3 py-2 text-base font-bold text-indigo-300 hover:bg-indigo-900 hover:text-white border border-indigo-500/30">
                        Upload Game
                    </a>
                @endif
            @endauth
        </div>
        
        <div class="border-t border-gray-700 pb-3 pt-4">
            @auth
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="h-10 w-10 rounded-full border-2 border-indigo-500" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="">
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