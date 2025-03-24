<x-layout>
    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">Back to Dashboard</a>
    <div class="bg-white shadow-md rounded-lg p-6 mb-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}'s Posts</h2>
           
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $posts->total() }} posts
            </span>
        </div>
    </div>
{{-- posts --}}
 
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
    @foreach ($posts as $post)
        
        <x-postCard :post="$post" />
    @endforeach
</div>
<x-pagination :posts="$posts" />

</x-layout>