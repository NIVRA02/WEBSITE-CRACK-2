<x-layout>
    <x-slot:title>{{$title}}</x-slot>

    <div class="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-2xl">
        <h1 class="text-3xl font-bold text-white mb-6 border-b border-gray-700 pb-3">Form Upload Game Baru</h1>
        
        <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium leading-6 text-white">Judul Game</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                @error('title')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="developer" class="block text-sm font-medium leading-6 text-white">Nama Developer</label>
                <input type="text" name="developer" id="developer" required value="{{ old('developer') }}"
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                @error('developer')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="poster" class="block text-sm font-medium leading-6 text-white">Poster Game (JPG/PNG, Max 2MB)</label>
                <input type="file" name="poster" id="poster" required
                    class="block w-full text-sm text-gray-300
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100">
                @error('poster')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium leading-6 text-white">Deskripsi Game</label>
                <textarea name="description" id="description" rows="5" required
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">{{ old('description') }}</textarea>
                @error('description')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="requirements" class="block text-sm font-medium leading-6 text-white">Syarat Sistem (Minimum/Recommended)</label>
                <textarea name="requirements" id="requirements" rows="4" required
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">{{ old('requirements') }}</textarea>
                @error('requirements')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="trailer_url" class="block text-sm font-medium leading-6 text-white">Link Trailer (Full URL YouTube, Opsional)</label>
                <input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url') }}"
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                @error('trailer_url')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="download_link" class="block text-sm font-medium leading-6 text-white">Link Download Game (Full URL)</label>
                <input type="url" name="download_link" id="download_link" required value="{{ old('download_link') }}"
                    class="block w-full rounded-md border-0 bg-white/5 py-2 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                @error('download_link')<p class="mt-2 text-sm text-red-400">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-lg font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 transition-colors">
                PUBLIKASIKAN GAME
            </button>
        </form>
    </div>
</x-layout>