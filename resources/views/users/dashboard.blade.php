<x-layout>
    <a href="{{ route('posts.index') }}" class="text-blue-500 hover:text-blue-700">Back to Posts</a>

    <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ auth()->user()->name }}</h1>
    <p class="text-gray-600">
        @if($posts->total() > 0)
            You have <span class="font-semibold text-blue-500">{{ $posts->total() }} posts</span>
        @else
            You don't have any posts yet 
        @endif
    </p>

    {{-- Create Post Section with Alpine.js --}}
   <x-formePost/>

    {{-- Last Posts --}}
    <h2 class="font-bold text-lg mt-6 mb-4">Your Last Posts</h2>

    @if($posts->count() > 0)
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
            @foreach ($posts as $post)
               <x-postCard :post="$post">
                {{-- Update Button --}}
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-white hover:text-white bg-green-500 py-1 px-2 rounded-md text-xs">
                        Update
                    </a>

                    {{-- Delete Button with SweetAlert --}}
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" id="delete-form-{{$post->id}}">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="text-white py-1 px-2 rounded-md bg-red-500 text-xs"
                            onclick="confirmDelete({{ $post->id }})">
                            Delete
                        </button>
                    </form>
               </x-postCard> 
            @endforeach
        </div>
    @else
        <p class="text-gray-500">You don't have any posts yet</p>
    @endif   

    {{-- Pagination --}}
    <x-pagination :posts="$posts" />

    {{-- SweetAlert Confirmation --}}
    <script>
        function confirmDelete(postId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action is irreversible!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#EF4444",
                cancelButtonColor: "#3B82F6",
                confirmButtonText: '<i class="fa-solid fa-trash"></i> Delete',
                cancelButtonText: '<i class="fa-solid fa-xmark"></i> Cancel',
                buttonsStyling: false,
                showClass: { popup: 'animate__animated animate__fadeIn' },
                hideClass: { popup: 'animate__animated animate__fadeOut' },
                customClass: {
                    popup: 'max-w-md rounded-xl shadow-2xl p-6',
                    title: 'text-xl font-bold text-gray-800 mb-4',
                    htmlContainer: 'text-base text-gray-600 mb-6',
                    actions: 'flex gap-3 justify-end',
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2',
                    cancelButton: 'bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${postId}`).submit();
                }
            });
        }
    </script>
</x-layout>
