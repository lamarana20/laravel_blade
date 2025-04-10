<x-layout>
    <div class="max-w-3xl mx-auto mt-6 p-6 bg-white shadow-lg rounded-xl">
        <h2 class="text-2xl font-bold mb-4">Edit Comment</h2>

        {{-- Commentaire Form --}}
        <form action="{{ route('comments.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <textarea name="content" rows="4" class="w-full border-gray-300 p-2 rounded-lg" placeholder="Edit comment..." required>{{ old('content', $comment->content) }}</textarea>
            </div>

            @error('content')
                <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
            @enderror

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
            Update Comment
            </button>
        </form>

        {{-- Retour to show post --}}
        <div class="mt-4">
            <a href="{{ route('posts.show', $comment->post) }}" class="text-blue-500 hover:text-blue-700">back to show</a>
        </div>
    </div>
</x-layout>
