<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Studio & Developer
            </h2>
            <p class="mt-4 text-lg text-gray-400">
                Temukan game favoritmu berdasarkan penciptanya.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($developers as $dev)
                <a href="{{ route('developers.show', $dev->developer) }}" class="group relative block h-full">
                    <div class="flex h-full flex-col justify-between rounded-2xl bg-gray-800 p-6 shadow-lg transition-all duration-300 group-hover:-translate-y-2 group-hover:bg-gray-750 group-hover:shadow-2xl ring-1 ring-white/5 group-hover:ring-indigo-500/50">
                        
                        <div>
                            <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-indigo-600/20 text-2xl font-bold text-indigo-400 ring-1 ring-indigo-500/30 transition-all group-hover:bg-indigo-600 group-hover:text-white">
                                {{ substr($dev->developer, 0, 1) }}
                            </div>

                            <h3 class="text-xl font-bold text-white transition-colors group-hover:text-indigo-300">
                                {{ $dev->developer }}
                            </h3>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-gray-700 pt-4">
                            <div class="flex items-center space-x-2 text-gray-400 group-hover:text-gray-300">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                                <span class="text-sm font-medium">{{ $dev->total_games }} Game</span>
                            </div>
                            
                            <span class="transform text-indigo-500 opacity-0 transition-all duration-300 group-hover:translate-x-1 group-hover:opacity-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </span>
                        </div>

                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h3 class="mt-2 text-sm font-medium text-white">Belum ada developer</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai upload game agar daftar ini terisi.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>