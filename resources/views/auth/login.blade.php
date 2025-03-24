<x-layout>
    {{-- Page Title --}}
    <h1 class="title">Welcome Back</h1>
    {{-- flash message --}}
    @if(session('status'))
    <x-flashMessage msg="{{ session('status') }}" />
    @endif

    {{-- Registration Form Container --}}
    <div class="mx-auto max-w-sm card">
        <form action="{{ route('login') }}" method="POST"
        x-data="formSubmit" @submit.prevent="submit" >
            @csrf

            
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

             {{-- Remember Me Checkbox --}}
            <div class="mb-4 flex justify-between items-center">
                <label for="remember" class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <span class="text-sm">Remember Me</span>
                </label>
                <a href="{{route('password.request')}}" class="text-sm text-blue-500 hover:underline">Forgot Password?</a>
            </div>            
          

            {{-- Submit Button --}}
            <button x-ref="btn" type="submit" class="primary-btn">login</button>
        </form>
    </div>
</x-layout>