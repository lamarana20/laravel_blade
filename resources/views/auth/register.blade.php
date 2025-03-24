{{-- Registration Form Layout --}}
<x-layout>
    {{-- Page Title --}}
    <h1 class="title">Register Account</h1>

    {{-- Registration Form Container --}}
    <div class="mx-auto max-w-sm card">
        <form action="{{ route('register') }}" method="POST"
        x-data="formSubmit" @submit.prevent="submit" >
            @csrf

            {{-- Name Field --}}
            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input type="text" name="name" id="name" class="input @error('name') ring-red-500 @enderror" value="{{ old('name') }}">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Email Field --}}
            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input type="text" name="email" id="email" class="input @error('email') ring-red-500 @enderror" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="mb-4">
                <label for="password" class="label">Password</label>
                <input type="password" name="password" id="password" class="input @error('password') ring-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Confirmation Field --}}
            <div class="mb-4">
                <label for="password_confirmation" class="label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="input @error('password') ring-red-500 @enderror"
                    
               >
               @error('password')
               <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
               @enderror
               
            </div>
            {{-- subscribe checkbox --}}
            <div class="mb-4 flex items-center">
                <input type="checkbox" name="subscribe" id="subscribe" class="mr-2">
                <label for="subscribe" class="label">Subscribe to our newsletter</label>
            </div>

            {{-- Submit Button --}}
            <button x-ref="btn" type="submit" class="primary-btn">Register</button>
        </form>
    </div>
</x-layout>