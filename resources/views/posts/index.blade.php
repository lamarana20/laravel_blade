<x-layout>
    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 flex justify-end">Go to Dashboard</a>
    <h1 class="title">Latest Posts</h1>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2  md:grid-cols-2 lg:grid-cols-3 mt-2.5 ">
        @foreach ($posts as $post)
            
            <x-postCard :post="$post" />
        @endforeach
    </div>
    <x-pagination :posts="$posts" />
 
    
</x-layout>
