@props(['post',])
<div class="bg-white rounded-xl shadow-md w-full max-w-2xl mx-auto p-5 transition hover:shadow-lg flex flex-col min-h-[200px]">
    
    <div class="flex items-center gap-3 mb-3">
        <!-- Avatar and link to profile -->
        <a href="{{ route('posts.user', $post->user->id) }}" class="flex items-center space-x-2 rounded-full focus:outline-none">
            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm"
               src="https://picsum.photos/seed/{{ $post->user->id }}/200"
                 alt="{{ $post->user->name }}">
        </a>

        <!-- Name + date -->
        <div class="flex flex-col">
            <a href="{{ route('posts.user', $post->user->id) }}" class="text-sm text-gray-800 font-medium hover:underline">
                {{ $post->user->name ?? 'Anonymous Developer' }}
            </a>
            <span class="text-xs text-gray-500">
                {{ $post->created_at->diffForHumans() ?? '1w' }}
            </span>
        </div>
    </div>
    
    <!-- Body -->
    <div class="text-gray-800 text-[15px] leading-snug mb-2 flex-grow">
        {{ Str::words($post->body, 10, '...') }}
    </div>

    <a href="{{ route('posts.show', $post) }}" class="text-green-700 font-semibold text-sm hover:underline">
        read more
    </a>

    <!-- Footer -->
    <div class="flex items-center justify-between mt-auto text-gray-500 text-sm pt-4">
        <div class="flex items-center gap-4">
            <form action="{{ route('posts.jaimer', $post) }}" method="POST" id="like-form-{{ $post->id }}">
                @csrf
                <button type="button" class="flex items-center gap-1 hover:text-green-700" onclick="toggleLike({{ $post->id }})">
                    <i id="like-icon-{{ $post->id }}" class="{{ auth()->user() && $post->jaimes->contains('user_id', auth()->id()) ? 'fas' : 'far' }} fa-heart"></i>
                    <span id="like-count-{{ $post->id }}">{{ $post->jaimes->count() }} likes</span>
                </button>
            </form>

            <!-- Link to comments -->
            <a href="{{ route('posts.show', $post) }}#comments"
               class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-md hover:bg-green-200 transition">
                <i class="far fa-comment"></i>
                <span>{{ $post->comments->count() }} comments</span>
            </a>
        </div>

        <!-- Slot for actions -->
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function toggleLike(postId) {
        axios.post(`/posts/${postId}/jaimer`)
            .then(response => {
                // Update like count and icon
                const likeIcon = document.getElementById(`like-icon-${postId}`);
                const likeCount = document.getElementById(`like-count-${postId}`);

                likeCount.textContent = `${response.data.likes_count} likes`;

                if (response.data.liked) {
                    likeIcon.classList.remove('far');
                    likeIcon.classList.add('fas');
                } else {
                    likeIcon.classList.remove('fas');
                    likeIcon.classList.add('far');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>