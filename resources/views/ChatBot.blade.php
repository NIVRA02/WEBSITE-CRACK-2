<x-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="mx-auto max-w-4xl px-4 py-10">
        
        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-indigo-600 shadow-lg shadow-indigo-500/30">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
            </div>
            <h2 class="text-3xl font-bold text-white">Nivra AI Assistant</h2>
            <p class="text-gray-400">Tanyakan apa saja tentang game atau website ini!</p>
        </div>

        <div class="flex h-[500px] flex-col overflow-hidden rounded-2xl bg-gray-800 shadow-2xl ring-1 ring-white/10">
            
            <div id="chat-box" class="flex-1 space-y-4 overflow-y-auto p-6 scroll-smooth custom-scrollbar">
                <div class="flex items-start">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <div class="ml-3 rounded-2xl rounded-tl-none bg-gray-700 px-4 py-2 text-sm text-white shadow-md">
                        Halo! Ada yang bisa saya bantu hari ini? 👋
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 bg-gray-900 p-4">
                <form id="chat-form" class="relative flex items-center gap-2">
                    @csrf
                    <input type="text" id="user-input" 
                        class="w-full rounded-full border-0 bg-gray-800 px-6 py-3 text-white placeholder-gray-500 shadow-inner ring-1 ring-gray-700 focus:ring-2 focus:ring-indigo-500" 
                        placeholder="Ketik pesanmu di sini..." required autocomplete="off">
                    
                    <button type="submit" id="send-btn" class="rounded-full bg-indigo-600 p-3 text-white shadow-lg transition hover:bg-indigo-500 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const userInput = document.getElementById('user-input');
        const sendBtn = document.getElementById('send-btn');

        // Fungsi Menambah Chat Bubble
        function appendMessage(text, sender) {
            const div = document.createElement('div');
            const isUser = sender === 'user';
            
            div.className = `flex items-start ${isUser ? 'justify-end' : ''}`;
            div.innerHTML = `
                ${!isUser ? '<div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600"><svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>' : ''}
                <div class="${isUser ? 'mr-3 bg-indigo-600 text-white rounded-tr-none' : 'ml-3 bg-gray-700 text-white rounded-tl-none'} rounded-2xl px-4 py-2 text-sm shadow-md max-w-[80%]">
                    ${text}
                </div>
                ${isUser ? '<div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-600"><svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>' : ''}
            `;
            
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll ke bawah
        }

        // Event Submit Form
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = userInput.value.trim();
            if (!message) return;

            // Tampilkan pesan user
            appendMessage(message, 'user');
            userInput.value = '';
            sendBtn.disabled = true;

            // Tampilkan Loading Sementara
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'loading-bubble';
            loadingDiv.className = 'flex items-start';
            loadingDiv.innerHTML = `
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600"><svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
                <div class="ml-3 rounded-2xl rounded-tl-none bg-gray-700 px-4 py-2 text-sm text-gray-400 shadow-md italic">
                    Sedang mengetik...
                </div>
            `;
            chatBox.appendChild(loadingDiv);
            chatBox.scrollTop = chatBox.scrollHeight;

            try {
                // Kirim ke Backend Laravel
                const response = await fetch('/chatbot/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                // Hapus Loading & Tampilkan Balasan AI
                document.getElementById('loading-bubble').remove();
                appendMessage(data.reply, 'ai');
            } catch (error) {
                document.getElementById('loading-bubble').remove();
                appendMessage('Maaf, koneksi terputus. Coba lagi nanti.', 'ai');
            } finally {
                sendBtn.disabled = false;
                userInput.focus();
            }
        });
    </script>
</x-layout>