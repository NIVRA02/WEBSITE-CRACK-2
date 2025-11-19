<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="space-y-8 rounded-2xl bg-gray-800 p-6 shadow-2xl lg:p-10">
        
        <div class="flex flex-col items-start justify-between border-b border-gray-700 pb-8 md:flex-row">
            <div class="w-full">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">{{ $game->title }}</h1>
                <div class="mt-3 flex items-center space-x-4">
                    <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-sm font-medium text-indigo-400 ring-1 ring-inset ring-indigo-500/20">
                        {{ $game->developer }}
                    </span>
                </div>
                
                @auth
                    @if(Auth::user()->is_admin)
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('games.edit', $game->id) }}" class="inline-flex items-center rounded-md bg-yellow-500/10 px-3 py-2 text-sm font-medium text-yellow-500 ring-1 ring-inset ring-yellow-500/20 transition hover:bg-yellow-500 hover:text-gray-900">
                                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                Edit Game
                            </a>

                            <form id="delete-game-{{ $game->id }}" action="{{ route('games.destroy', $game->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDeletion('delete-game-{{ $game->id }}', 'Game ini akan dihapus permanen beserta posternya!')"
                                        class="inline-flex items-center rounded-md bg-red-500/10 px-3 py-2 text-sm font-medium text-red-500 ring-1 ring-inset ring-red-500/20 transition hover:bg-red-500 hover:text-white">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Hapus Game
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            <a href="{{ $game->download_link }}" target="_blank" class="mt-6 inline-flex shrink-0 items-center rounded-xl bg-green-600 px-8 py-4 text-lg font-bold text-white shadow-lg shadow-green-900/20 transition hover:bg-green-500 hover:scale-105 md:mt-0">
                <svg class="mr-2 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                DOWNLOAD
            </a>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-8">
                <div class="overflow-hidden rounded-xl shadow-2xl bg-gray-900">
                    <img class="w-full object-cover opacity-90 transition hover:opacity-100" src="{{ asset('storage/' . $game->poster) }}" alt="Poster {{ $game->title }}">
                </div>
                
                @if($videoId)
                    <div class="overflow-hidden rounded-xl shadow-2xl ring-1 ring-white/10">
                        <iframe class="w-full h-[400px]" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif
                
                <div class="prose prose-invert max-w-none">
                    <h3 class="text-2xl font-bold text-white">Tentang Game Ini</h3>
                    <div class="mt-4 whitespace-pre-wrap text-gray-300 leading-relaxed">{{ $game->description }}</div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-8">
                
                <div class="rounded-xl bg-gray-700/50 p-6 shadow-inner ring-1 ring-white/5">
                    <h3 class="mb-4 flex items-center font-bold text-white">
                        <svg class="mr-2 h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Syarat Sistem
                    </h3>
                    <div class="text-sm text-gray-300 font-mono whitespace-pre-wrap bg-gray-900/50 p-3 rounded-lg border border-gray-700">{{ $game->requirements }}</div>
                </div>

                <div class="pt-6 border-t border-gray-700">
                    <h3 class="mb-6 text-2xl font-bold text-white flex items-center">
                        Komentar <span class="ml-3 rounded-full bg-gray-700 px-2.5 py-0.5 text-sm font-medium text-gray-300">{{ $game->comments->count() }}</span>
                    </h3>

                    @auth
                        <form action="/games/{{ $game->id }}/comments" method="POST" class="mb-8 relative">
                            @csrf
                            <textarea name="body" rows="3" placeholder="Bagikan pendapatmu..." class="block w-full rounded-xl border-0 bg-gray-900/80 p-4 text-white shadow-sm ring-1 ring-inset ring-gray-700 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" required></textarea>
                            <button type="submit" class="absolute bottom-2 right-2 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white shadow hover:bg-indigo-500">Kirim</button>
                        </form>
                    @else
                        <div class="mb-8 rounded-xl bg-indigo-900/20 p-4 text-center border border-indigo-500/20">
                            <p class="text-indigo-200 text-sm">Ingin berkomentar? <a href="{{ route('login') }}" class="font-bold underline hover:text-white">Login dulu yuk!</a></p>
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse($game->comments->sortByDesc('created_at') as $comment)
                            <div class="group relative rounded-xl bg-gray-700/40 p-4 hover:bg-gray-700/60 transition-colors ring-1 ring-white/5">
                                <div class="flex justify-between items-start">
                                    
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $comment->user->name }}</p>
                                            <p class="text-[10px] text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                                @if($comment->created_at != $comment->updated_at)
                                                    <span class="ml-1 text-gray-500 italic">(diedit)</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    @auth
                                        @if(Auth::id() === $comment->user_id || Auth::user()->is_admin)
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('comments.edit', $comment->id) }}" 
                                                   class="rounded-md bg-gray-800 px-2.5 py-1.5 text-xs font-medium text-gray-400 ring-1 ring-inset ring-gray-600 transition-colors hover:bg-indigo-600 hover:text-white hover:ring-indigo-500"
                                                   title="Edit Komentar">
                                                    Edit
                                                </a>
                                                
                                                <form id="delete-comment-{{ $comment->id }}" action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            onclick="confirmDeletion('delete-comment-{{ $comment->id }}', 'Hapus komentar ini?')"
                                                            class="rounded-md bg-gray-800 px-2.5 py-1.5 text-xs font-medium text-gray-400 ring-1 ring-inset ring-gray-600 transition-colors hover:bg-red-600 hover:text-white hover:ring-red-500"
                                                            title="Hapus Komentar">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth

                                </div>
                                
                                <p class="mt-3 text-sm text-gray-300 leading-relaxed pl-11">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 italic text-sm">Belum ada komentar. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>