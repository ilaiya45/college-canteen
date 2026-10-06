<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Forgot Password</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100 min-h-screen">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 sm:p-10">

            {{-- Title --}}

            <div class="text-center mb-8">

                <div
                    class="w-16 h-16 mx-auto mb-5 rounded-2xl
                           bg-gradient-to-br from-indigo-500 to-purple-600
                           flex items-center justify-center"
                >

                    <svg
                        class="w-8 h-8 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 7a2 2 0 11-4 0 2 2 0 014 0z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v6m0 0l-2 2m2-2l2 2"
                        />

                    </svg>

                </div>


                <h1 class="text-2xl font-bold text-gray-800">
                    Forgot Password?
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Enter your email address to receive a password reset link.
                </p>

            </div>


            {{-- Success Message --}}

            @if (session('status'))

                <div
                    class="mb-5 p-3 rounded-lg
                           bg-green-100
                           text-green-700
                           text-sm"
                >

                    {{ session('status') }}

                </div>

            @endif


            {{-- Validation Errors --}}

            @if ($errors->any())

                <div
                    class="mb-5 p-3 rounded-lg
                           bg-red-100
                           text-red-700
                           text-sm"
                >

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Form --}}

            <form
                method="POST"
                action="{{ route('password.email') }}"
                class="space-y-5"
            >

                @csrf


                {{-- Email --}}

                <div>

                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl
                               border-gray-300
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                        placeholder="Enter your email"
                    >

                    @error('email')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Submit --}}

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           transition"
                >

                    Send Password Reset Link

                </button>

            </form>


            {{-- Back to Login --}}

            <div class="text-center mt-6">

                <a
                    href="{{ route('login') }}"
                    class="text-sm text-indigo-600
                           font-medium
                           hover:underline"
                >

                    ← Back to Login

                </a>

            </div>

        </div>

    </div>

</body>

</html>