<x-layout>
    <x-slot:title>Edit Game</x-slot>

    <div class="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-8 border-b border-gray-700 pb-4">Edit Game: {{ $game->title }}</h1>
        
        <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Judul Game</label>
                <input type="text" name="title" value="{{ old('title', $game->title) }}" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Developer</label>
                <input type="text" name="developer" value="{{ old('developer', $game->developer) }}" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="5" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ old('description', $game->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Syarat Sistem</label>
                <textarea name="requirements" rows="3" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ old('requirements', $game->requirements) }}</textarea>
            </div>

            <div class="bg-gray-700/30 p-4 rounded-lg border border-gray-700 border-dashed">
                <label class="block text-sm font-medium text-gray-300 mb-3">Poster Game (Opsional)</label>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="shrink-0">
                        <p class="text-xs text-gray-500 mb-1">Poster Saat Ini:</p>
                        <img class="h-20 w-auto rounded shadow-md ring-1 ring-white/10" src="{{ asset('storage/' . $game->poster) }}" alt="Poster Lama">
                    </div>
                    <div class="text-sm text-gray-400">
                        <p>Jika tidak ingin mengubah poster,</p>
                        <p>biarkan input di bawah ini kosong.</p>
                    </div>
                </div>

                <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input type="file" name="poster" class="block w-full text-sm text-gray-400
                        file:mr-4 file:py-2.5 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-600 file:text-white
                        hover:file:bg-indigo-500
                        transition-all cursor-pointer
                    "/>
                </label>
                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG (Max 2MB)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Trailer URL (YouTube)</label>
                <input type="url" name="trailer_url" value="{{ old('trailer_url', $game->trailer_url) }}" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Link Download</label>
                <input type="url" name="download_link" value="{{ old('download_link', $game->download_link) }}" class="w-full rounded-lg bg-gray-900 text-white p-3 border border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-700">
                <a href="{{ route('games.show', $game->title) }}" class="px-6 py-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 transition-all">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>
</x-layout>