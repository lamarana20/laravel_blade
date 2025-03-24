<x-layout>
    {{-- Page Title --}}
    <h1 class="title">Request the password by a email</h1>

    {{-- flash message --}}
    @if (session('status'))
        <x-flashMessage msg="{{ session('status') }}" />
    @endif

    {{-- Registration Form Container --}}
    <div class="mx-auto max-w-sm card">
        <form action="{{ route('password.request') }}" method="POST" x-data="formSubmit" @submit.prevent="submit">
            @csrf

            {{-- Email Field --}}
            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input type="text" name="email" id="email" class="input @error('email') ring-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button x-ref="btn" type="submit" class="primary-btn">submit</button>
        </form>
    </div>
</x-layout>
