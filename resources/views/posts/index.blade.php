<x-layout>
    <!-- Lien vers le Dashboard -->
    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 flex justify-end mb-4">Go to Dashboard</a>

    <!-- Titre de la page -->
    <h1 class="title text-center text-2xl font-bold mb-6">Latest Posts</h1>

    <!-- Grille de posts -->
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 mt-2.5 px-4">
        @foreach ($posts as $post)
            <x-postCard :post="$post" />
        @endforeach
    </div>

    <!-- Pagination -->
    <x-pagination :posts="$posts" />
</x-layout>
