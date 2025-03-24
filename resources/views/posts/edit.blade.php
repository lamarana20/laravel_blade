<x-layout>
    <a href="{{route('dashboard')}}" class="block mb-2 text-xs text-blue-500"> &larr;Back to dashboard</a>

<div class="card mb-4 bg-white shadow-md rounded-lg p-6 mt-10">
    <h2 class="font-bold mb-3 text-center">Update post</h2>

<form action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data"
    x-data="formSubmit" @submit.prevent="submit" >
    @method('put')  
    @csrf
  
    {{-- title --}}
    <div class="mb-4">
        <label for="title" class="label">Title</label>
        <input type="text" name="title" id="title" class="input @error('title') ring-red-500 @enderror" value="{{ $post->title }}">
        @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    {{-- body --}}
    <div class="mb-4">
        <label for="body" class="label">post content</label>
        <textarea name="body" id="body" rows="4" class="input @error('body') ring-red-500 @enderror">{{ $post->body }}</textarea>
        @error('body')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    {{-- current image --}}
    @if ($post->image)
    <div class="h-64 rounded-md overflow-hidden mb-4 w-1/4 object-cover">
        
        <label > Current Image</label>
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"  class="object-cover">
        </div>

        @endif
        <div class="mb-4">
            <label for="image" class="label">Image</label>
            <input type="file" name="image" id="image" class="input @error('image') ring-red-500 @enderror">
            @error('image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            </div>
   
    {{-- submit button --}}
    <button  x-ref="btn" type="submit" class="primary-btn">Update</button>
</form>
</div>
</x-layout>