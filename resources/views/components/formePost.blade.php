<div class="card mb-4 bg-white shadow-md rounded-lg p-6 sticky">
    <h2 class="font-bold mb-4">Create a post</h2>

    {{-- session message --}}
    @if (session('success'))
        <x-flashMessage msg="{{ session('success') }}" />
    @elseif(session('delete'))
        <x-flashMessage msg="{{ session('delete') }}" bg="bg-red-500" />
    @elseif(session('update'))
        <x-flashMessage msg="{{ session('update') }} by {{ auth()->user()->name }}" bg="bg-green-500" />
    @endif
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">    
        @csrf
        {{-- title --}}
        <div class="mb-4">
            <label for="title" class="label">Title</label>
            <input type="text" name="title" id="title" class="input @error('title') ring-red-500 @enderror" value="{{ old('title') }}">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- body --}}
        <div class="mb-4">
            <label for="body" class="label">Post content</label>
            <textarea name="body" id="body" rows="4" class="input @error('body') ring-red-500 @enderror">{{ old('body') }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- image --}}
        <div class="mb-4">
            <label for="image" class="label">Image</label>
            <p class="text-sm text-red-600 mb-2">Choose an image or a default one will be used</p>
            <input type="file" name="image" id="image" class="input @error('image') ring-red-500 @enderror">
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- submit button --}}
        <button type="submit" class="primary-btn">Create</button>
    </form>
</div>
