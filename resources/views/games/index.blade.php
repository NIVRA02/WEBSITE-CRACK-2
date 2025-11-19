<x-layout>
    <x-slot:title>{{$title}}</x-slot>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($games as $game)
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:scale-[1.02]">
                <a href="{{ route('games.show', $game->title) }}">
                    <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $game->poster) }}" alt="{{ $game->title }} Poster">
                </a>
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-white truncate">{{ $game->title }}</h3>
                    <p class="text-sm text-indigo-400 mt-1">{{ $game->developer }}</p>
                    <p class="text-gray-400 text-sm mt-3 line-clamp-3">{{ Str::limit($game->description, 80) }}</p>
                    
                    <a href="{{ route('games.show', $game->title) }}" class="mt-4 block text-center bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <p class="text-white text-lg col-span-4">Belum ada game yang diupload. {{ Auth::check() && Auth::user()->is_admin ? 'Ayo upload game pertama Anda!' : '' }}</p>
        @endforelse
    </div>

</x-layout>