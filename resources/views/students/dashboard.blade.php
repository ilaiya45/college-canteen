<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background:#0F3D2E">
                <svg class="w-5 h-5" style="color:#FBB017" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <span class="font-semibold text-lg" style="color:#0F3D2E">Adhi Canteen</span>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap');

        .cn { --green:#0F3D2E; --yellow:#FBB017; --leaf:#7BA23F; --cream:#FFFBF0; font-family:'Nunito',system-ui,sans-serif; }
        .cn .f-display { font-family:'Baloo 2','Nunito',sans-serif; }
        .cn .f-script  { font-family:'Caveat','Nunito',cursive; }

        /* ---------- the one orchestrated moment: hero entrance ---------- */
        .cn .pop { opacity:0; transform:translateY(26px) scale(.96); animation:cnPop .7s cubic-bezier(.2,.9,.3,1.2) forwards; }
        .cn .d1{animation-delay:.05s} .cn .d2{animation-delay:.2s} .cn .d3{animation-delay:.4s} .cn .d4{animation-delay:.6s}
        @keyframes cnPop { to { opacity:1; transform:none; } }

        .cn .underline-draw { stroke-dasharray:300; stroke-dashoffset:300; animation:cnDraw 1s .9s ease forwards; }
        @keyframes cnDraw { to { stroke-dashoffset:0; } }

        /* drifting leaves + steam */
        .cn .leaf { position:absolute; animation:cnFloat 7s ease-in-out infinite; }
        .cn .leaf.l2 { animation-duration:9s; animation-delay:-3s; }
        @keyframes cnFloat { 0%,100%{transform:translateY(0) rotate(-8deg)} 50%{transform:translateY(-14px) rotate(8deg)} }

        .cn .steam { position:absolute; bottom:38%; width:10px; height:60px; border-radius:99px;
            background:linear-gradient(to top, rgba(255,255,255,.7), transparent);
            filter:blur(5px); opacity:0; animation:cnSteam 3.2s ease-in infinite; }
        @keyframes cnSteam { 0%{opacity:0; transform:translateY(0) scaleX(1)} 30%{opacity:.8} 100%{opacity:0; transform:translateY(-70px) scaleX(2.2)} }

        /* ---------- menu ticker ---------- */
        .cn .ticker { display:flex; width:max-content; animation:cnTicker 28s linear infinite; }
        .cn .ticker:hover { animation-play-state:paused; }
        @keyframes cnTicker { to { transform:translateX(-50%); } }

        /* ---------- action cards: respond to touch/hover ---------- */
        .cn .action { transition:transform .25s ease, box-shadow .25s ease; }
        .cn .action:hover { transform:translateY(-6px) rotate(-.6deg); }
        .cn .action .arrow { transition:transform .25s ease; }
        .cn .action:hover .arrow { transform:translateX(6px); }
        .cn .action:focus-visible, .cn .btn:focus-visible { outline:3px solid var(--yellow); outline-offset:3px; }

        @media (prefers-reduced-motion: reduce) {
            .cn *, .cn *::before { animation:none !important; transition:none !important; }
            .cn .pop { opacity:1; transform:none; }
            .cn .underline-draw { stroke-dashoffset:0; }
        }
    </style>

    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $menu = ['🍚 Idli', '🍩 Medu Vada', '☕ Filter Coffee', '🍔 Burger', '🥤 Milkshake', '🍛 Lemon Rice', '🥥 Coconut Chutney', '🍲 Sambar'];
    @endphp

    <div class="cn py-8 sm:py-12 min-h-screen" style="background:var(--cream)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ===== HERO ===== --}}
            <section class="relative overflow-hidden rounded-[2rem] shadow-xl mb-8 bg-white"
                     style="box-shadow:0 20px 50px -20px rgba(15,61,46,.35)">

                {{-- Save your poster as public/images/canteen-banner.png --}}
                <div class="absolute inset-0 bg-cover bg-right"
                     style="background-image:url('{{ asset('images/canteen-banner.png') }}'); background-color:#e6f2ff"></div>
                <div class="absolute inset-0"
                     style="background:linear-gradient(90deg,#fffbf0 0%,#fffbf0 42%,rgba(255,251,240,.75) 58%,rgba(255,251,240,0) 82%)"></div>

                {{-- steam over the cup --}}
                <div class="hidden lg:block absolute right-[28%] top-0 bottom-0 pointer-events-none" aria-hidden="true">
                    <span class="steam" style="left:0"></span>
                    <span class="steam" style="left:22px; animation-delay:1.1s"></span>
                    <span class="steam" style="left:-20px; animation-delay:2s"></span>
                </div>

                {{-- leaves --}}
                <svg class="leaf" style="left:14px;top:10px" width="46" height="60" viewBox="0 0 46 60" aria-hidden="true">
                    <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#7BA23F"/>
                </svg>
                <svg class="leaf l2 hidden sm:block" style="right:24px;top:14px" width="40" height="50" viewBox="0 0 46 60" aria-hidden="true">
                    <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#FBB017"/>
                </svg>

                <div class="relative px-6 sm:px-10 py-10 sm:py-14 max-w-3xl">

                    <p class="pop d1 f-script text-2xl sm:text-3xl" style="color:var(--green)">
                        {{ $greeting }}, {{ Str::before(Auth::user()->name, ' ') }}!
                    </p>

                    <h1 class="pop d2 f-display font-extrabold leading-[1.05] mt-1" style="color:var(--green)">
                        <span class="block text-xl sm:text-3xl">Adhi College of Engineering</span>
                        <span class="block text-xl sm:text-3xl">and Technology</span>
                        <span class="block text-6xl sm:text-8xl mt-1" style="color:var(--yellow)">CANTEEN</span>
                    </h1>

                    <svg class="pop d3" width="220" height="14" viewBox="0 0 220 14" fill="none" aria-hidden="true">
                        <path class="underline-draw" d="M4 9C50 2 120 2 216 8" stroke="#0F3D2E" stroke-width="3" stroke-linecap="round"/>
                    </svg>

                    <p class="pop d3 f-script text-2xl sm:text-3xl mt-1" style="color:var(--green)">Good Food • Great Mood</p>

                    <p class="pop d4 mt-4 max-w-md text-base sm:text-lg" style="color:#2b5a49">
                        Fuel your dreams with delicious and hygienic food at our college canteen.
                    </p>

                    <div class="pop d4 mt-6 flex flex-wrap items-center gap-3">
                        <a href="{{ route('food.index') }}"
                           class="btn inline-flex items-center gap-2 px-6 py-3 rounded-full font-bold text-white transition hover:scale-105 active:scale-95"
                           style="background:var(--green)">
                            Order now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="btn inline-flex items-center gap-2 px-5 py-3 rounded-full font-semibold transition hover:bg-white"
                                    style="border:2px solid var(--green); color:var(--green)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9"/></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <p class="pop d4 f-script hidden md:block absolute right-10 top-16 text-4xl -rotate-6 text-center leading-9" style="color:var(--green)">
                    Eat<br>Learn<br>Grow
                </p>
            </section>

            {{-- ===== MENU TICKER ===== --}}
            <div class="overflow-hidden rounded-full mb-8 py-3" style="background:var(--green)" aria-label="Today's favourites">
                <div class="ticker">
                    @foreach ([1, 2] as $loop2)
                        @foreach ($menu as $item)
                            <span class="f-display font-semibold text-lg px-6 whitespace-nowrap" style="color:var(--yellow)">{{ $item }}</span>
                            <span class="text-white/40" aria-hidden="true">•</span>
                        @endforeach
                    @endforeach
                </div>
            </div>

            {{-- ===== QUICK ACTIONS ===== --}}
            <section class="rounded-3xl p-4 sm:p-6 bg-white" style="border:2px solid #f3e6c4">
                <h2 class="f-display font-extrabold text-2xl mb-4" style="color:var(--green)">What would you like to do?</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    {{-- Food --}}
                    <a href="{{ route('food.index') }}" class="action group relative overflow-hidden p-6 rounded-3xl text-white"
                       style="background:var(--green); box-shadow:0 12px 24px -12px rgba(15,61,46,.7)">
                        <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full" style="background:rgba(251,176,23,.25)"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4" style="background:var(--yellow); color:var(--green)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8h1a4 4 0 010 8h-1M5 8h13v9a4 4 0 01-4 4H9a4 4 0 01-4-4V8zM5 8L7 2h10l2 6"/></svg>
                            </div>
                            <h3 class="f-display text-2xl font-extrabold">View food</h3>
                            <p class="mt-1 text-white/80">See what's fresh in the canteen today.</p>
                            <span class="inline-flex items-center gap-2 mt-4 font-bold" style="color:var(--yellow)">
                                Browse menu
                                <svg class="arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="action group relative overflow-hidden p-6 rounded-3xl"
                       style="background:var(--yellow); color:var(--green); box-shadow:0 12px 24px -12px rgba(251,176,23,.9)">
                        <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full" style="background:rgba(255,255,255,.35)"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4 text-white" style="background:var(--green)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3 class="f-display text-2xl font-extrabold">My cart</h3>
                            <p class="mt-1" style="color:#4a3a06">Check the items you've picked.</p>
                            <span class="inline-flex items-center gap-2 mt-4 font-bold">
                                Go to cart
                                <svg class="arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('orders.index') }}" class="action group relative overflow-hidden p-6 rounded-3xl"
                       style="background:#e4f0cf; color:var(--green); box-shadow:0 12px 24px -12px rgba(123,162,63,.8)">
                        <div class="absolute -right-6 -top-6 w-28 h-28 rounded-full" style="background:rgba(123,162,63,.25)"></div>
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-4 text-white" style="background:var(--leaf)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="f-display text-2xl font-extrabold">My orders</h3>
                            <p class="mt-1" style="color:#2b5a49">Track and review past orders.</p>
                            <span class="inline-flex items-center gap-2 mt-4 font-bold">
                                View orders
                                <svg class="arrow w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </a>

                </div>
            </section>

            {{-- ===== PROMISES ===== --}}
            <section class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ([
                    ['Tasty food',      '#FDE9A8', '🍽️'],
                    ['Hygienic & safe', '#CFEBB3', '🌿'],
                    ['Affordable prices','#FAC8C0', '₹'],
                    ['For every student','#BFE3F9', '🎓'],
                ] as [$label, $bg, $icon])
                    <div class="flex items-center gap-3 rounded-2xl p-4 bg-white" style="border:2px solid #f3e6c4">
                        <span class="w-12 h-12 shrink-0 rounded-full flex items-center justify-center text-xl f-display font-extrabold"
                              style="background:{{ $bg }}; color:var(--green)">{{ $icon }}</span>
                        <span class="font-bold leading-tight" style="color:var(--green)">{{ $label }}</span>
                    </div>
                @endforeach
            </section>

        </div>
    </div>

</x-app-layout>
