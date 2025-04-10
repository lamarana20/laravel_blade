<x-layout>
    @if (session('success'))
        <x-flashMessage msg="{{ session('success') }}" />
    @elseif(session('delete'))
        <x-flashMessage msg="{{ session('delete') }}" bg="bg-red-500" />
    @elseif(session('update'))
        <x-flashMessage msg="{{ session('update') }} by {{ auth()->user()->name }}" bg="bg-green-500" />
    @endif
    <div class="max-w-4xl mx-auto mt-8 p-8 bg-white shadow-2xl rounded-2xl">
        {{-- Navigation Buttons --}}
        <div class="flex justify-between mb-8">
            <a href="{{ route('posts.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-300 ease-in-out transform hover:-translate-x-1">
                <span class="fa-solid fa-arrow-left mr-2"></span> Back
            </a>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition duration-300 ease-in-out transform hover:translate-x-1">
                Dashboard <span class="fa-solid fa-arrow-right ml-2"></span>
            </a>
        </div>

        {{-- Post Content --}}
        <div class="bg-gray-50 p-8 rounded-xl shadow-lg relative">
            {{-- Image --}}

            <div class="h-32 w-32 rounded-lg overflow-hidden flex-shrink-0" id="thumbnailContainer">
                @if ($post->image && Storage::disk('public')->exists($post->image))
                    <!-- Si l'image existe dans le répertoire de stockage, on l'affiche -->
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-full object-cover cursor-pointer"
                         onclick="openImageModal('{{ asset('storage/' . $post->image) }}')">
                @else
                    <!-- Si l'image n'existe pas, on affiche l'image par défaut -->
                    <img src="{{ asset('storage/posts_images/default.png') }}" 
                         alt="Default Image"
                         class="w-full h-full object-cover opacity-70 cursor-pointer"
                         onclick="openImageModal('{{ asset('storage/posts_images/default.png') }}')">
                @endif
            </div>
            
            {{-- Modal for full-size image --}}
            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden items-center justify-center z-50"
                onclick="closeImageModal()">
                <img id="modalImageContent" src="" alt="Full size image"
                    class="max-w-[95%] max-h-[95vh] object-contain">
            </div>
            {{-- Title --}}
            <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>

            {{-- Metadata --}}
            <div class="flex items-center justify-between mb-6 text-sm text-gray-600">
                <span class="flex items-center">
                    <span class="fa-regular fa-calendar mr-2"></span>
                    {{ $post->created_at->format('M d, Y') }}
                </span>
                <span class="flex items-center">
                    <span class="fa-regular fa-user mr-2"></span>
                    <a href="{{ route('posts.user', $post->user) }}"
                        class="text-blue-600 font-medium hover:text-blue-800 transition">
                        {{ $post->user->name ?? 'Unknown' }}
                    </a>
                </span>
            </div>

            {{-- Post Body --}}
            <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed mb-8">
                {!! nl2br(e($post->body)) !!}
            </div>


            {{-- Actions (Edit / Delete) : Only for author --}}
            @auth
                @if (auth()->user()->id == $post->user_id)
                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 flex items-center">
                            <span class="fa-regular fa-edit mr-2"></span> Edit
                        </a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-300 flex items-center">
                                <span class="fa-regular fa-trash-alt mr-2"></span> Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Comments Section --}}
        <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-2xl font-bold mb-6">Comments</h3>

            <div id="commentsContainer" class="max-h-[800px] overflow-hidden">
                @foreach ($comments as $comment)
                    <div
                        class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg mb-4 hover:bg-gray-100 transition-colors duration-200">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 border-2 border-gray-200">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm"
                                src="https://picsum.photos/seed/{{ $comment->user->id }}/200"
                                alt="{{ $comment->user->name }}">
                        </div>

                        {{-- Comment Content --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span
                                    class="font-semibold text-gray-900">{{ $comment->user->name ?? 'Unknown User' }}</span>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 leading-relaxed">{{ $comment->content }}</p>
                            {{-- Like Button --}}
                            <div class="mt-3 flex items-center gap-4">
                                <form action="{{ route('comments.like', $comment) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <span class="fa-regular fa-thumbs-up mr-1"></span>
                                        {{ $comment->likes->count() }} <i>likes</i>
                                    </button>
                                </form>

                                @auth
                                    @if ($comment->likes->where('user_id', auth()->user()->id)->count())
                                        <span class="text-blue-600">You liked this</span>
                                    @endif
                                @endauth
                            </div>

                            {{-- Edit / Delete --}}
                            @auth
                                @if (auth()->user()->id == $comment->user_id)
                                    <div class="flex mt-3 gap-4">
                                        <a href="{{ route('comments.edit', $comment) }}"
                                            class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <span class="fa-regular fa-edit mr-1"></span> Edit
                                        </a>

                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 flex items-center">
                                                <span class="fa-regular fa-trash-alt mr-1"></span> Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($comments) > 10)
                <button id="readMoreBtn"
                    class="mt-4 w-full py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-300">
                    Read More Comments
                </button>
            @endif
        </div>

        {{-- Add a comment --}}
        @auth
            <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-2xl font-bold mb-4">Add a Comment</h3>
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" rows="4"
                            class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Share your thoughts..." required></textarea>
                    </div>

                    @error('content')
                        <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
                    @enderror

                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 flex items-center">
                        <span class="fa-regular fa-paper-plane mr-2"></span> Post Comment
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImageContent');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });

        // Read More Comments functionality
        const readMoreBtn = document.getElementById('readMoreBtn');
        if (readMoreBtn) {
            readMoreBtn.addEventListener('click', function() {
                const commentsContainer = document.getElementById('commentsContainer');
                commentsContainer.style.maxHeight = 'none';
                this.style.display = 'none';
            });
        }
    </script>
</x-layout>
