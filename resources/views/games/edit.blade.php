<x-layout>
    <x-slot:title>Edit Game</x-slot>
    <div class="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-6 border-b border-gray-700 pb-3">Edit Game: {{ $game->title }}</h1>
        <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT') <div><label class="block text-white">Judul</label><input type="text" name="title" value="{{ $game->title }}" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700"></div>
            <div><label class="block text-white">Developer</label><input type="text" name="developer" value="{{ $game->developer }}" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700"></div>
            <div><label class="block text-white">Deskripsi</label><textarea name="description" rows="5" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700">{{ $game->description }}</textarea></div>
            <div><label class="block text-white">Syarat Sistem</label><textarea name="requirements" rows="3" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700">{{ $game->requirements }}</textarea></div>
            <div><label class="block text-white">Poster (Isi jika ingin ganti)</label><input type="file" name="poster" class="block w-full text-gray-300"></div>
            <div><label class="block text-white">Trailer URL</label><input type="url" name="trailer_url" value="{{ $game->trailer_url }}" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700"></div>
            <div><label class="block text-white">Download Link</label><input type="url" name="download_link" value="{{ $game->download_link }}" class="w-full rounded bg-gray-900 text-white p-2 border border-gray-700"></div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 rounded">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</x-layout>