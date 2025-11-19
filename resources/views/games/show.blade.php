<x-layout>
    <x-slot:title>{{$title}}</x-slot>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-gray-800 rounded-xl shadow-2xl p-6 lg:p-10 space-y-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-700 pb-6">
            <div>
                <h1 class="text-4xl font-bold text-white">{{ $game->title }}</h1>
                <p class="text-xl text-indigo-400 mt-2">Oleh: {{ $game->developer }}</p>
            </div>
            <a href="{{ $game->download_link }}" target="_blank" class="mt-4 md:mt-0 bg-green-600 hover:bg-green-500 text-white font-extrabold text-lg py-3 px-8 rounded-xl transition-colors shadow-lg">
                <i class="fas fa-download mr-2"></i> DOWNLOAD GAME
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <img class="w-full h-auto rounded-lg shadow-xl mb-6" src="{{ asset('storage/' . $game->poster) }}" alt="Poster {{ $game->title }}">
                
                @if($videoId)
                    <h3 class="text-2xl font-semibold text-white mt-8 mb-4">Video Trailer</h3>
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="rounded-lg"></iframe>
                    </div>
                @endif
                
                <h3 class="text-2xl font-semibold text-white mt-8 mb-4 border-b border-gray-700 pb-2">Deskripsi Game</h3>
                <div class="text-gray-300 whitespace-pre-wrap">{{ $game->description }}</div>
            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-4">
                    <h3 class="text-2xl font-semibold text-white mb-4 border-b border-gray-700 pb-2">Syarat Sistem</h3>
                    <div class="bg-gray-700 p-4 rounded-lg text-gray-300 whitespace-pre-wrap">
                        {{ $game->requirements }}
                    </div>

                    <h3 class="text-2xl font-semibold text-white mt-8 mb-4 border-b border-gray-700 pb-2">Komentar ({{ $game->comments->count() }})</h3>
                    
                    @auth
                        <form method="POST" action="/games/{{ $game->id }}/comments" class="mb-6">
                            @csrf
                            <textarea name="body" rows="3" required placeholder="Tulis komentar Anda di sini..." class="w-full rounded-lg bg-gray-900 border border-gray-700 text-white p-3 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            @error('body')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="mt-2 bg-indigo-600 hover:bg-indigo-500 text-white py-2 px-4 rounded-lg text-sm font-semibold">Kirim Komentar</button>
                        </form>
                    @endauth

                    @guest
                        <p class="text-gray-400 p-4 bg-gray-700 rounded-lg text-center">
                            Anda harus <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-bold">login</a> untuk memberikan komentar.
                        </p>
                    @endguest

                    <div class="space-y-4 mt-6">
                        @forelse ($game->comments->sortByDesc('created_at') as $comment)
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <p class="text-white font-semibold">{{ $comment->user->name }} 
                                    <span class="text-xs text-gray-400 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </p>
                                <p class="text-gray-300 mt-1">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400">Belum ada komentar untuk game ini.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layout>