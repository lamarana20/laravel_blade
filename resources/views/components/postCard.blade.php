@props(['post', 'showBody' => false])

<div class="bg-white shadow-lg rounded-xl p-6 w-full md:max-w-2xl hover:shadow-xl transition-transform transform hover:scale-105 duration-200 flex gap-6">
    {{-- Image --}}
    <div class="h-40 w-40 rounded-lg overflow-hidden flex-shrink-0 shadow-md">
        @if ($post->image && Storage::disk('public')->exists($post->image))
            <img src="{{ asset('storage/' . $post->image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-full object-cover hover:opacity-90 transition-opacity">
        @else
            <img src="{{ asset('storage/posts_images/default.png') }}" 
                 alt="Default Image"
                 class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
        @endif
    </div>
    
    {{-- Content --}}
    <div class="flex-1 min-w-0 flex flex-col justify-between">
        {{-- Title --}}
        <h2 class="font-bold text-xl text-gray-800 hover:text-blue-600 transition-colors truncate">
            {{ $post->title }}
        </h2>

        {{-- Post Meta Info --}}
        <div class="text-sm font-medium text-gray-600 mt-2 flex justify-between items-center">
            <span class="flex items-center gap-2">
                <i class="far fa-clock"></i>
                {{ $post->created_at->diffForHumans() }}
            </span>
            <a href="{{ route('posts.user', $post->user) }}" 
               class="text-blue-500 font-medium hover:text-blue-700 flex items-center gap-1">
                <i class="far fa-user"></i>
                {{ $post->user->name ?? 'username' }}
            </a>
        </div>

        {{-- Body --}}
        <div class="mt-3 text-gray-700 text-sm leading-relaxed">
            @if ($showBody)
                <p class="whitespace-normal break-words">
                    {{ $post->body }}
                </p>
            @else
                <span class="overflow-hidden line-clamp-3">
                    {{ Str::words($post->body, 20) }}
                </span>
                <a href="{{ route('posts.show', $post) }}" 
                   class="text-blue-600 font-semibold hover:text-blue-800 inline-flex items-center gap-1 mt-2">
                    Read more 
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            @endif
        </div>

        {{-- Actions (Slot) --}}
        <div class="flex justify-between items-center mt-4">
            <div class="flex items-center gap-4">
                <form action="{{ route('posts.jaimer', $post) }}" method="POST" class="flex items-center">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-colors">
                        <i class="far fa-heart text-lg"></i>
                        <span class="font-medium">{{ $post->jaimes->count() }}</span>
                    </button>
                </form>
            
                @auth
                    @if ($post->jaimes->where('user_id', auth()->user()->id)->count())
                        <span class="text-blue-600 text-sm italic">
                            <i class="fas fa-check-circle mr-1"></i>
                        </span>
                    @endif
                @endauth
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('posts.show', $post) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white py-1.5 px-3 rounded-full text-sm font-medium transition-colors flex items-center gap-1">
                    <i class="far fa-comment-dots"></i>
                   Comments <span>{{ $post->comments->count() }}</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>