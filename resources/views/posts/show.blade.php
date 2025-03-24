<x-layout>
    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-lg rounded-xl">

        {{-- Back Button --}}
        <div class="flex justify-between mb-6">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center text-gray-700 hover:text-blue-500 transition duration-300 ease-in-out transform hover:-translate-x-1">
                <span class="fa-solid fa-arrow-left text-blue-500 mr-2"></span> Back
            </a>
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center text-blue-500 hover:text-blue-500 transition duration-300 ease-in-out transform hover:translate-x-1">
             Dashboard <span class="fa-solid fa-arrow-right text-blue-500 ml-2"></span>
            </a>
        </div>        {{-- Post Content --}}
        <div class="bg-gray-50 p-6 rounded-lg shadow-md relative">

            {{-- Image --}}
            @if ($post->image)

                <div class="w-full h-64 mb-4 rounded-lg overflow-hidden cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $post->image) }}')">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" 

                          class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Modal for full-size image --}}
            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closeImageModal()">
                <img id="modalImage" src="" alt="Full size image" class="max-w-[90%] max-h-[90vh] object-contain">
            </div>


            {{-- Title --}}
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            {{-- Metadata --}}
            <div class="text-sm text-gray-500 mb-4 flex justify-between">
                <span>📅 {{ $post->created_at->format('M d, Y') }}</span>
                <span>✍️ <a href="{{ route('posts.user', $post->user) }}" 
                            class="text-blue-500 font-medium hover:text-blue-700">
                    {{ $post->user->name ?? 'Unknown' }}</a>
                </span>
            </div>

            {{-- Post Content with Copy Button --}}
            <div class="relative">
                <div id="postBody" class="text-gray-800 leading-relaxed text-lg border-l-4 border-blue-500 pl-4 pr-12">
                    {!! nl2br(e($post->body)) !!}
                </div>

                {{-- Copy Button --}}
                <button onclick="copyText()" id="copyButton"
                        class="absolute top-0 right-0 mt-2 mr-2 bg-gray-200 p-2 rounded-full shadow-md hover:bg-gray-300 transition flex items-center gap-2 text-gray-700">
                    <span class="fa-solid fa-copy">cp</span>
                </button>

                {{-- Confirmation Message --}}
                <div id="copyMessage"
                     class="hidden absolute top-0 right-10 bg-green-500 text-white text-xs py-1 px-3 rounded-md shadow-md">
                    Copied!
                </div>
            </div>

            {{-- Actions (Edit / Delete) : Only for author --}}
            @auth
                @if(auth()->user()->id == $post->user_id)
                    <div class="mt-6 flex justify-end gap-4">
                        <a href="{{ route('posts.edit', $post) }}" 
                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                           ✏️ Edit
                        </a>
                        
                    </div>
                @endif
            @endauth

        </div>
    </div>

    {{-- Script to copy text --}}
    <script>
        function copyText() {
            const text = document.getElementById("postBody").innerText;
            navigator.clipboard.writeText(text).then(() => {
                // Display "Copied!" message
                let copyMessage = document.getElementById("copyMessage");
                copyMessage.classList.remove("hidden");

                // Change button icon
                let copyButton = document.getElementById("copyButton");
                copyButton.innerHTML = '<span class="fa-solid fa-check text-green-600"></span>';

                // Hide message after 1.5 seconds
                setTimeout(() => {
                    copyMessage.classList.add("hidden");
                    copyButton.innerHTML = '<span class="fa-solid fa-copy"></span>';
                }, 2000);
            }).catch(err => {
                console.error("Error copying text", err);
            });
        }
        // Function to open the modal with the full-size image

       
                function openImageModal(imageSrc) {
                    const modal = document.getElementById('imageModal');
                    const modalImage = document.getElementById('modalImage');
                    modalImage.src = imageSrc;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                }

                function closeImageModal() {
                    const modal = document.getElementById('imageModal');
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
          
    </script>
</x-layout>
