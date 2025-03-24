@props(['post', 'showBody' => false])

<div class="bg-white shadow-lg rounded-xl p-4 w-full md:max-w-2xl hover:shadow-xl transition-transform transform hover:scale-105 duration-200 flex gap-4">
    {{-- Image --}}
    <div class="h-32 w-32 rounded-lg overflow-hidden flex-shrink-0">
        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-full object-cover">
        @else
            <img src="{{ asset('storage/posts_images/default.png') }}" 
                 alt="Default Image"
                 class="w-full h-full object-cover opacity-70">
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0 flex flex-col justify-between">
        {{-- Title --}}
        <h2 class="font-bold text-lg text-gray-800 hover:text-blue-600 transition-colors truncate">
            {{ $post->title }}
        </h2>

        {{-- Post Meta Info --}}
        <div class="text-sm font-light text-gray-500 mt-1 flex justify-between items-center">
            <span class="flex items-center gap-1">
                {{ $post->created_at->diffForHumans() }}
            </span>
            <a href="{{ route('posts.user', $post->user) }}" 
               class="text-blue-500 font-medium hover:text-blue-700">
                👤 {{ $post->user->name ?? 'username' }}
            </a>
        </div>

        {{-- Body --}}
        <div class="mt-2 text-gray-700 text-sm leading-snug">
            @if ($showBody)
                <p class="whitespace-normal break-words">
                    {{ $post->body }}
                </p>
            @else
                <span class="overflow-hidden line-clamp-5">
                    {{ Str::words($post->body, 15) }}
                </span>
                <a href="{{ route('posts.show', $post) }}" 
                   class="text-blue-500 font-semibold hover:text-blue-700">
                    Read more →
                </a>
            @endif
        </div>

        {{-- Actions (Slot) --}}
        <div class="flex justify-end items-center mt-3 gap-3">
            {{ $slot }}
        </div>
    </div>
</div>