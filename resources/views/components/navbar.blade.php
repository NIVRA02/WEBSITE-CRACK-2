<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <!-- Load Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Inter Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-900 min-h-screen">

    <!-- START OF NAV CODE (With Blade Logic Cleaned Up) -->

    
    <nav class="bg-gray-800/70 backdrop-blur-sm shadow-xl" x-data="{isOpen: false, isProfileOpen: false}">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <!-- Logo -->
                        <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="size-8" />
                    </div>
                    
                    <!-- Desktop Navigation Links (FIXED SECTION) -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <!-- Helper function for simulated active state. Replace this with your actual Blade logic: 
                                 {{ request()->is('/path') ? '...' : '...' }} -->
                            <script>
                                // HACK: Simulate PHP request()->is() for a runnable HTML file
                                const currentPath = window.location.pathname === '/' ? '/' : window.location.pathname.replace(/\/$/, "");
                                function isActive(path) {
                                    // Use path === '/' to handle the root case correctly, 
                                    // or check if currentPath starts with the link's path for broader matching if needed.
                                    return currentPath === path; 
                                }
                            </script>

                            <!-- Common classes are outside the Blade condition for consistency (px-3 py-2, text-sm, rounded-md) -->
                            
                            <a href="/" 
                                aria-current="page" 
                                class="
                                    px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                    {{-- Blade Logic Starts Here --}}
                                    {{ request()->is('/')
                                        ? 'bg-indigo-600/70 text-white shadow-md' 
                                        : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                                    }}
                                    {{-- End Blade Logic --}}
                                "
                                :class="{'bg-indigo-600/70 text-white shadow-md': isActive('/'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/')}"
                            >Home</a>

                            <a href="/developer" 
                                class="
                                    px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                    {{-- Blade Logic Starts Here --}}
                                    {{ request()->is('/developer')
                                        ? 'bg-indigo-600/70 text-white shadow-md' 
                                        : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                                    }}
                                    {{-- End Blade Logic --}}
                                "
                                :class="{'bg-indigo-600/70 text-white shadow-md': isActive('/developer'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/developer')}"
                            >Developer</a>

                            <a href="/Chatbot" 
                                class="
                                    px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                    {{-- Blade Logic Starts Here --}}
                                    {{ request()->is('/Chatbot')
                                        ? 'bg-indigo-600/70 text-white shadow-md' 
                                        : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                                    }}
                                    {{-- End Blade Logic --}}
                                "
                                :class="{'bg-indigo-600/70 text-white shadow-md': isActive('/Chatbot'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/Chatbot')}"
                            >Chatbot</a>

                            <a href="/contact" 
                                class="
                                    px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                    {{-- Blade Logic Starts Here --}}
                                    {{ request()->is('/contact')
                                        ? 'bg-indigo-600/70 text-white shadow-md' 
                                        : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                                    }}
                                    {{-- End Blade Logic --}}
                                "
                                :class="{'bg-indigo-600/70 text-white shadow-md': isActive('/contact'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/contact')}"
                            >Contact Us</a>

                            <!-- Since this link's URL is '#' and used the active check for '/', I changed the active style to inactive style for consistency -->
                            <a href="#" 
                                class="
                                    px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                    text-gray-300 hover:bg-white/10 hover:text-white
                                "
                            >Reports</a>
                        </div>
                    </div>
                </div>

                <!-- Profile Menu (Desktop) -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative ml-3" @click.away="isProfileOpen = false">
                            <button type="button" @click="isProfileOpen = !isProfileOpen"
                                class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile Picture" class="size-8 rounded-full outline -outline-offset-1 outline-white/10" />
                            </button>

                            <div x-show="isProfileOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-xl bg-gray-800 py-1 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 transition-colors duration-150">Your profile</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 transition-colors duration-150">Settings</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 transition-colors duration-150">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button type="button" @click="isOpen = !isOpen" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/10 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 transition-colors duration-150" aria-controls="mobile-menu" :aria-expanded="isOpen">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        
                        <!-- Icon when menu is closed -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6" :class="{'hidden': isOpen, 'block': !isOpen}">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        
                        <!-- Icon when menu is open -->
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6" :class="{'block': isOpen, 'hidden': !isOpen}">
                            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (FIXED LINKS) -->
        <div id="mobile-menu" x-show="isOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="md:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                <!-- Mobile Link Home (Active) -->
                <a href="/" aria-current="page" 
                    class="
                        block rounded-md px-3 py-2 text-base font-medium transition-colors duration-150
                        {{ request()->is('/') 
                            ? 'bg-indigo-600/70 text-white' 
                            : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                        }}
                    "
                    :class="{'bg-indigo-600/70 text-white': isActive('/'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/')}"
                >Home</a>
                
                <!-- Mobile Link Developer (Inactive Example) -->
                <a href="/developer" 
                    class="
                        block rounded-md px-3 py-2 text-base font-medium transition-colors duration-150
                        {{ request()->is('/developer') 
                            ? 'bg-indigo-600/70 text-white' 
                            : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                        }}
                    "
                    :class="{'bg-indigo-600/70 text-white': isActive('/developer'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/developer')}"
                >Developer</a>
                
                <!-- Mobile Link Chatbot (Inactive Example) -->
                <a href="/Chatbot" 
                    class="
                        block rounded-md px-3 py-2 text-base font-medium transition-colors duration-150
                        {{ request()->is('/Chatbot') 
                            ? 'bg-indigo-600/70 text-white' 
                            : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                        }}
                    "
                    :class="{'bg-indigo-600/70 text-white': isActive('/Chatbot'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/Chatbot')}"
                >Chatbot</a>
                
                <!-- Mobile Link Contact (Inactive Example) -->
                <a href="/contact" 
                    class="
                        block rounded-md px-3 py-2 text-base font-medium transition-colors duration-150
                        {{ request()->is('/contact') 
                            ? 'bg-indigo-600/70 text-white' 
                            : 'text-gray-300 hover:bg-white/10 hover:text-white' 
                        }}
                    "
                    :class="{'bg-indigo-600/70 text-white': isActive('/contact'), 'text-gray-300 hover:bg-white/10 hover:text-white': !isActive('/contact')}"
                >Contact Us</a>
                
                <!-- Mobile Link Reports (Inactive Example) -->
                <a href="#" 
                    class="
                        block rounded-md px-3 py-2 text-base font-medium transition-colors duration-150
                        text-gray-300 hover:bg-white/10 hover:text-white
                    "
                >Reports</a>
            </div>
            
            <!-- Mobile Profile Menu -->
            <div class="border-t border-white/10 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile Picture" class="size-10 rounded-full outline -outline-offset-1 outline-white/10" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">Tom Cook</div>
                        <div class="text-sm font-medium text-gray-400">tom@example.com</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/10 hover:text-white transition-colors duration-150">Your profile</a>
                    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/10 hover:text-white transition-colors duration-150">Settings</a>
                    <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/10 hover:text-white transition-colors duration-150">Sign out</a>
                </div>
            </div>
        </div>
    </nav>


</body>
</html>