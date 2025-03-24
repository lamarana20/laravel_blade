<x-layout>
    <div class="max-w-lg mx-auto text-center p-6 bg-white shadow-lg rounded-lg">
        <h1 class="mb-4 text-2xl font-bold text-gray-800">
            📩 Verify Your Email Address
        </h1>
        <p class="mb-4 text-gray-600">
            We’ve sent you a verification email. Please check your inbox and click the link to confirm your email address.
        </p>
        <p class="mb-4 text-gray-600">
            Didn’t receive the email? No worries! You can request a new one below. 📬
        </p>

        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                🔄 Resend Verification Email
            </button>
        </form>
    </div>
</x-layout>
