<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen | Adhi College of Engineering and Technology</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --green: #0b4a35;
            --green-deep: #06301f;
            --yellow: #f9c910;
            --cream: #fff8e1;
        }
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Baloo 2', cursive; }

        /* Slow zoom on banner photo */
        @keyframes kenburns { from { transform: scale(1); } to { transform: scale(1.12) translateX(-1.5%); } }
        .bg-photo { animation: kenburns 24s ease-in-out infinite alternate; }

        /* One page-load sequence: card slides in, then items pop in order */
        @keyframes slideIn { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: none; } }
        @keyframes pop { from { opacity: 0; transform: scale(.7); } to { opacity: 1; transform: scale(1); } }
        .card-in { animation: slideIn .8s cubic-bezier(.2,.8,.2,1) both; }
        .pop { animation: pop .5s cubic-bezier(.3,1.5,.5,1) both; }

        /* Rotating tagline words */
        @keyframes word { 0%,4% { opacity: 0; transform: translateY(14px); } 8%,30% { opacity: 1; transform: none; } 34%,100% { opacity: 0; transform: translateY(-14px); } }
        .word { position: absolute; left: 0; opacity: 0; animation: word 9s infinite; }
        .word:nth-child(2) { animation-delay: 3s; }
        .word:nth-child(3) { animation-delay: 6s; }

        /* Floating food */
        @keyframes floaty { 0%,100% { transform: translateY(0) rotate(-4deg); } 50% { transform: translateY(-22px) rotate(6deg); } }
        .floaty { animation: floaty 6s ease-in-out infinite; }

        /* Menu marquee */
        @keyframes marquee { to { transform: translateX(-50%); } }
        .marquee { animation: marquee 28s linear infinite; }

        /* Steam over the coffee */
        @keyframes steam { 0% { opacity: 0; transform: translateY(0) scaleX(1); } 40% { opacity: .7; } 100% { opacity: 0; transform: translateY(-40px) scaleX(1.6); } }
        .steam { animation: steam 3s ease-out infinite; }

        /* Shine sweep on the main button */
        @keyframes shine { to { transform: translateX(250%) skewX(-20deg); } }
        .btn-shine::after {
            content: ''; position: absolute; inset: 0 auto 0 -60%; width: 40%;
            background: rgba(255,255,255,.55); transform: skewX(-20deg);
            animation: shine 3.2s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
            .word:first-child { opacity: 1; }
        }
    </style>
</head>

<body class="min-h-screen bg-[var(--green-deep)] text-white overflow-x-hidden">

<main class="relative min-h-screen flex flex-col">

    {{-- Background photo (copy your banner to public/images/snacks/canteen-banner.png) --}}
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/snacks/demo.png') }}" alt=""
             class="bg-photo absolute inset-0 w-full h-full object-cover object-right">
        <div class="absolute inset-0 bg-gradient-to-r from-[var(--green-deep)] via-[var(--green)]/85 to-transparent md:via-[var(--green)]/60"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[var(--green-deep)]/80 via-transparent to-transparent"></div>
    </div>

    {{-- Floating food (visible on larger screens) --}}
    <div class="pointer-events-none absolute inset-0 hidden md:block" aria-hidden="true">
        <span class="floaty absolute top-[16%] right-[8%] text-6xl">🥘</span>
        <span class="floaty absolute top-[52%] right-[40%] text-5xl" style="animation-delay:-2s">🍩</span>
        <span class="floaty absolute bottom-[22%] right-[6%] text-6xl" style="animation-delay:-4s">🥞</span>
        <span class="absolute bottom-[34%] right-[27%] text-5xl floaty" style="animation-delay:-1s">
            ☕<i class="steam absolute left-3 -top-2 text-xl not-italic">〰</i>
        </span>
    </div>

    {{-- Top bar --}}
    <header class="relative z-10 flex items-center gap-3 px-5 sm:px-10 pt-6">
        <div class="w-12 h-12 rounded-xl bg-[var(--yellow)] text-[var(--green)] grid place-items-center text-2xl shadow-lg">🎓</div>
        <div class="leading-tight">
            <p class="font-display font-extrabold text-lg sm:text-xl">ADHI COLLEGE</p>
            <p class="text-[11px] sm:text-xs text-white/80">of Engineering and Technology</p>
        </div>
        <!--<p class="ml-auto hidden sm:block font-display text-xl text-[var(--yellow)] -rotate-3">Good Food, Better Days</p>-->
    </header>

    {{-- Hero --}}
    <section class="relative z-10 flex-1 flex items-center px-5 sm:px-10 py-10">
        <div class="card-in w-full max-w-lg">

            <h1 class="font-display font-extrabold text-[5.5rem] sm:text-[8rem] leading-[.85] text-[var(--yellow)] -rotate-2 drop-shadow-[0_6px_0_rgba(0,0,0,.25)]">
                Canteen
            </h1>

            {{-- Rotating words --}}
            <div class="relative h-9 mt-4 font-display text-2xl sm:text-3xl font-semibold" aria-live="off">
                <span class="word">Fresh Food 🥬</span>
                <span class="word">Great Taste 😋</span>
                <span class="word">Happy Moments 🎉</span>
            </div>

            {{-- Login panel --}}
            <div class="mt-7 rounded-3xl bg-white/12 backdrop-blur-xl ring-1 ring-white/25 p-5 sm:p-6 shadow-2xl shadow-black/30">
                <p class="text-sm text-white/85 mb-4">Order your food before the bell rings. No more long queues!</p>

                <a href="{{ route('login') }}"
                   class="btn-shine relative overflow-hidden flex items-center justify-center gap-2 w-full py-4 rounded-2xl
                          bg-[var(--yellow)] text-[var(--green-deep)] font-semibold text-lg
                          shadow-lg shadow-black/30 hover:scale-[1.03] active:scale-95 transition-transform duration-200
                          focus:outline-none focus-visible:ring-4 focus-visible:ring-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-4 0-8 2-8 4v1h16v-1c0-2-4-4-8-4z"/>
                    </svg>
                    Student Login / Register
                </a>

                <a href="{{ route('admin.login') }}"
                   class="mt-3 flex items-center justify-center gap-2 w-full py-3 rounded-2xl
                          ring-2 ring-white/50 text-white font-medium
                          hover:bg-white hover:text-[var(--green)] transition-colors duration-200
                          focus:outline-none focus-visible:ring-4 focus-visible:ring-[var(--yellow)]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Admin Login
                </a>
            </div>

            {{-- Feature chips --}}
            <ul class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs sm:text-[13px]">
                @foreach ([['🌿','Hygienic Food'],['🍲','Tasty & Nutritious'],['💰','Affordable Prices'],['❤️','For Every Student']] as $i => $f)
                    <li class="pop rounded-2xl bg-[var(--green-deep)]/70 ring-1 ring-[var(--yellow)]/60 py-3 px-2
                               hover:-translate-y-1 hover:bg-[var(--yellow)] hover:text-[var(--green-deep)] transition duration-200"
                        style="animation-delay: {{ 0.7 + $i * 0.12 }}s">
                        <span class="block text-2xl mb-1">{{ $f[0] }}</span>{{ $f[1] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Menu marquee --}}
    <div class="relative z-10 bg-[var(--yellow)] text-[var(--green-deep)] overflow-hidden py-3 font-display font-semibold text-lg">
        <div class="marquee flex w-max gap-10 whitespace-nowrap">
            @for ($r = 0; $r < 2; $r++)
                @foreach (['🍚 Pongal','🥞 Dosa','⚪ Idli','🍩 Vada','🍛 Veg Biryani','☕ Filter Coffee','🍟 French Fries','🍔 Burger','🥤 Cool Drinks','🍕 Pizza'] as $item)
                    <span>{{ $item }}</span>
                @endforeach
            @endfor
        </div>
    </div>

</main>

</body>
</html>
