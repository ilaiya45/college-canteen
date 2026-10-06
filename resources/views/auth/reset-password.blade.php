<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-gray-100 min-h-screen">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 sm:p-10">

            <div class="text-center mb-8">

                <h1 class="text-2xl font-bold text-gray-800">
                    Reset Password
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Create your new password.
                </p>

            </div>


            {{-- Errors --}}

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


            <form
                method="POST"
                action="{{ route('password.store') }}"
                class="space-y-5"
            >

                @csrf


                {{-- Token --}}

                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >


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
                        value="{{ old('email', $email) }}"
                        required
                        class="w-full rounded-xl
                               border-gray-300
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                    >

                </div>


                {{-- New Password --}}

                <div>

                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        New Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="w-full rounded-xl
                               border-gray-300
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                        placeholder="Enter new password"
                    >

                </div>


                {{-- Confirm Password --}}

                <div>

                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        class="w-full rounded-xl
                               border-gray-300
                               focus:border-indigo-500
                               focus:ring-indigo-500"
                        placeholder="Confirm new password"
                    >

                </div>


                {{-- Button --}}

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           transition"
                >

                    Reset Password

                </button>

            </form>


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