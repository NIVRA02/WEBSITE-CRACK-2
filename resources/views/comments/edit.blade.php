<x-layout>
    <x-slot:title>Edit Komentar</x-slot>

    <div class="flex min-h-[80vh] items-center justify-center px-4 py-12">
        <div class="w-full max-w-2xl transform rounded-2xl bg-gray-800 p-8 shadow-2xl transition-all duration-300 hover:shadow-indigo-500/10">
            
            <div class="mb-8 flex items-center border-b border-gray-700 pb-5">
                <div class="mr-4 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-600/20 text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Komentar</h2>
                    <p class="text-sm text-gray-400">Perbaiki atau tambahkan detail pada komentarmu.</p>
                </div>
            </div>
            
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6 group">
                    <label for="body" class="mb-2 block text-sm font-medium text-gray-300 transition-colors group-focus-within:text-indigo-400">
                        Isi Komentar
                    </label>
                    <div class="relative">
                        <textarea 
                            name="body" 
                            id="body" 
                            rows="6" 
                            class="block w-full resize-none rounded-xl border-0 bg-gray-900 p-4 text-white shadow-inner ring-1 ring-inset ring-gray-700 placeholder:text-gray-600 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-all duration-200 ease-in-out"
                            placeholder="Tulis sesuatu yang menarik..."
                            required>{{ old('body', $comment->body) }}</textarea>
                        
                        <div class="absolute bottom-3 right-3 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </div>
                    </div>

                    @error('body')
                        <p class="mt-2 flex items-center text-sm text-red-400 animate-pulse">
                            <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-end space-x-4 border-t border-gray-700 pt-6">
                    <a href="{{ route('games.show', $comment->game->title) }}" class="rounded-lg px-5 py-2.5 text-sm font-medium text-gray-400 transition-all duration-200 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        Batal
                    </a>
                    
                    <button type="submit" class="group relative inline-flex items-center justify-center overflow-hidden rounded-lg bg-indigo-600 px-8 py-2.5 text-sm font-bold text-white shadow-lg transition-all duration-200 hover:bg-indigo-500 hover:shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="mr-2">Simpan Perubahan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>