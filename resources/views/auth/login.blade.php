<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Campus Canteen</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --green:#0b4a35; --green-deep:#06301f; --yellow:#f9c910; }
        body { font-family:'Poppins',sans-serif; }
        .font-display { font-family:'Baloo 2',cursive; }

        @keyframes kenburns { from{transform:scale(1)} to{transform:scale(1.12) translateX(-1.5%)} }
        .bg-photo { animation:kenburns 24s ease-in-out infinite alternate; }

        @keyframes rise { from{opacity:0;transform:translateY(36px) scale(.97)} to{opacity:1;transform:none} }
        .rise { animation:rise .8s cubic-bezier(.2,.8,.2,1) both; }
        .stagger { animation:rise .6s cubic-bezier(.2,.8,.2,1) both; }

        @keyframes floaty { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-20px) rotate(6deg)} }
        .floaty { animation:floaty 6s ease-in-out infinite; }

        @keyframes shine { to{transform:translateX(250%) skewX(-20deg)} }
        .btn-shine::after { content:'';position:absolute;inset:0 auto 0 -60%;width:40%;background:rgba(255,255,255,.55);transform:skewX(-20deg);animation:shine 3.2s ease-in-out infinite; }

        @keyframes wave { 0%,100%{transform:rotate(0)} 20%{transform:rotate(16deg)} 40%{transform:rotate(-8deg)} 60%{transform:rotate(14deg)} }
        .wave { display:inline-block; transform-origin:70% 70%; animation:wave 2.4s ease-in-out infinite; }

        .field { transition:all .2s; }
        .field:focus { background:#fff; border-color:var(--green); box-shadow:0 0 0 4px rgba(249,201,16,.35); }

        @media (prefers-reduced-motion:reduce){ *,*::before,*::after{animation:none!important;transition:none!important} }
    </style>
</head>

<body class="min-h-screen relative flex items-center justify-center p-4 bg-[var(--green-deep)] overflow-x-hidden">

    {{-- Background photo --}}
    <div class="fixed inset-0 overflow-hidden -z-0">
        <img src="{{ asset('images/snacks/demo.png') }}" alt=""
             class="bg-photo absolute inset-0 w-full h-full object-cover object-right">
        <div class="absolute inset-0 bg-[var(--green-deep)]/75"></div>
    </div>

    {{-- Floating food --}}
    <div class="pointer-events-none fixed inset-0 hidden md:block" aria-hidden="true">
        <span class="floaty absolute top-[10%] left-[8%] text-5xl">🍕</span>
        <span class="floaty absolute top-[18%] right-[8%] text-5xl" style="animation-delay:-2s">🥤</span>
        <span class="floaty absolute bottom-[12%] left-[12%] text-5xl" style="animation-delay:-4s">🍔</span>
        <span class="floaty absolute bottom-[14%] right-[10%] text-5xl" style="animation-delay:-1s">🍟</span>
    </div>

    <div class="rise relative z-10 w-full max-w-4xl bg-white rounded-3xl shadow-2xl shadow-black/40 overflow-hidden flex flex-col md:flex-row">

        {{-- Left Panel: Branding --}}
        <div class="hidden md:flex md:w-2/5 flex-col justify-between p-10 text-white relative overflow-hidden bg-gradient-to-br from-[var(--green)] to-[var(--green-deep)]">
            <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-[var(--yellow)]/20"></div>
            <div class="absolute bottom-10 -left-10 w-40 h-40 rounded-full bg-[var(--yellow)]/15"></div>

            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-[var(--yellow)] text-[var(--green)] grid place-items-center text-3xl mb-8 shadow-lg hover:rotate-6 hover:scale-105 transition">🎓</div>
                <h1 class="font-display font-extrabold text-5xl leading-none text-[var(--yellow)] mb-3">
                    Welcome<br>back! <span class="wave">👋</span>
                </h1>
                <p class="text-white/85 text-sm leading-relaxed">
                    Login, pick your food, and skip the queue. Hot idli and filter coffee are waiting for you.
                </p>

                <ul class="mt-6 space-y-2 text-sm">
                    <li class="flex items-center gap-2">🌿 Hygienic food</li>
                    <li class="flex items-center gap-2">💰 Affordable prices</li>
                    <li class="flex items-center gap-2">⚡ Quick ordering</li>
                </ul>
            </div>

            <div class="relative z-10 text-xs text-white/60">
                &copy; {{ date('Y') }} Adhi College of Engineering and Technology
            </div>
        </div>

        {{-- Right Panel: Form --}}
        <div class="w-full md:w-3/5 p-8 sm:p-12">

            {{-- Mobile brand --}}
            <div class="md:hidden flex items-center gap-2 mb-6 font-display font-extrabold text-xl text-[var(--green)]">
                <span class="w-10 h-10 rounded-xl bg-[var(--yellow)] grid place-items-center">🎓</span> Campus Canteen
            </div>

            <h2 class="font-display font-extrabold text-3xl text-[var(--green)] mb-1">Log in to your account</h2>
            <p class="text-sm text-gray-500 mb-8">Enter your details below</p>

            @if (session('status'))
                <div class="mb-5 px-4 py-2.5 rounded-lg bg-green-50 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="stagger" style="animation-delay:.25s">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l9 6 9-6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               placeholder="you@example.com"
                               class="field w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 outline-none">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="stagger" style="animation-delay:.35s">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                               class="field w-full pl-11 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 outline-none">
                        <button type="button" onclick="togglePassword()" aria-label="Show or hide password"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[var(--green)]">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178.07.21.07.434 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="stagger flex items-center justify-between" style="animation-delay:.45s">
                    <label for="remember" class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-[var(--green)] focus:ring-[var(--yellow)]">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-[var(--green)] font-medium hover:underline">
                        Forgot password?
                    </a>
                </div>

                {{-- Login Button --}}
                <button type="submit"
                        class="stagger btn-shine relative overflow-hidden w-full py-3.5 rounded-xl bg-[var(--yellow)] text-[var(--green-deep)] font-semibold text-lg
                               shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-transform duration-150
                               focus:outline-none focus-visible:ring-4 focus-visible:ring-[var(--green)]/40"
                        style="animation-delay:.55s">
                    Log in 🍽️
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[var(--green)] font-semibold hover:underline">Sign up</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.852-.396M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.5a10.523 10.523 0 01-4.293 5.333M6.228 6.228L3 3m3.228 3.228l3.65 3.65m4.272 4.272L21 21" />
                `;
            } else {
                password.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.64 0 8.577 3.01 9.964 7.178.07.21.07.434 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.64 0-8.577-3.01-9.964-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                `;
            }
        }
    </script>
</body>
</html>
