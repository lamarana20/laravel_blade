{{-- Registration Form Layout --}}
<x-layout>
    {{-- Page Title --}}
    <h1 class="title">
        Reset  your Password
    </h1>
    {{-- flash message --}}
    @if(session('status'))
    <x-flashMessage msg="{{ session('status') }}" />
     @endif

    {{-- Registration Form Container --}}
    <div class="mx-auto max-w-sm card">
        <form action="{{route('password.update')}}" method="POST"
  >
            @csrf
<input  type="hidden" name="token" value="{{ $token }}">
          
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
          

            {{-- Submit Button --}}
            <button type="submit" class="primary-btn">Reset password</button>
        </form>
    </div>
</x-layout>