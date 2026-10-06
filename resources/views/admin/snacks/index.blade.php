<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Manage Snacks - College Canteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        html { -webkit-text-size-adjust:100%; }
        body { font-family:'Poppins',sans-serif; overflow-x:hidden; }
        .font-display { font-family:'Baloo 2',cursive; }

        /* Horizontal scroll rows (mobile filters) */
        .no-scrollbar { scrollbar-width:none; -ms-overflow-style:none; -webkit-overflow-scrolling:touch; }
        .no-scrollbar::-webkit-scrollbar { display:none; }

        @keyframes gradient-move { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .hero-bg { background:linear-gradient(120deg,#0b4a35,#06301f,#0f6b4b,#06301f); background-size:300% 300%; animation:gradient-move 14s ease infinite; }

        @keyframes floaty { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-12px) rotate(8deg)} }
        .floaty { animation:floaty 5s ease-in-out infinite; }

        @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        .bob { animation:bob 2.4s ease-in-out infinite; }

        @keyframes rise { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }
        .rise { animation:rise .55s cubic-bezier(.2,.8,.2,1) both; }

        .reveal { opacity:0; transform:translateY(28px) scale(.97); transition:opacity .6s cubic-bezier(.2,.8,.2,1), transform .6s cubic-bezier(.2,.8,.2,1); }
        .reveal.in { opacity:1; transform:none; }

        @keyframes shine { to{transform:translateX(250%) skewX(-20deg)} }
        .btn-shine { position:relative; overflow:hidden; }
        .btn-shine::after { content:'';position:absolute;inset:0 auto 0 -60%;width:40%;background:rgba(255,255,255,.55);transform:skewX(-20deg);animation:shine 3.2s ease-in-out infinite; }

        @keyframes pulse-ring { 0%{box-shadow:0 0 0 0 rgba(249,201,16,.7)} 100%{box-shadow:0 0 0 14px rgba(249,201,16,0)} }
        .pulse-ring { animation:pulse-ring 1.8s infinite; }

        .ripple { position:relative; overflow:hidden; -webkit-tap-highlight-color:transparent; }
        .ripple-wave { position:absolute; border-radius:9999px; background:rgba(255,255,255,.5); transform:scale(0); animation:ripple .6s linear; pointer-events:none; }
        @keyframes ripple { to{transform:scale(4);opacity:0} }

        @keyframes wiggle { 0%,100%{transform:rotate(0)} 20%{transform:rotate(-18deg) scale(1.15)} 40%{transform:rotate(14deg) scale(1.15)} 60%{transform:rotate(-10deg)} 80%{transform:rotate(6deg)} }

        .snack-card { transition:transform .25s, box-shadow .25s; }
        .snack-card .snack-img { transition:transform .6s cubic-bezier(.2,.8,.2,1); }
        .price-tag { transform:rotate(-3deg); transition:transform .25s; }
        .stat { transition:transform .25s, box-shadow .25s; }

        /* Hover effects only on devices that really hover (avoids "sticky" hover on touch) */
        @media (hover:hover) {
            .snack-card:hover { transform:translateY(-8px); box-shadow:0 22px 36px -16px rgba(11,74,53,.45); }
            .snack-card:hover .snack-img { transform:scale(1.12) rotate(1deg); }
            .snack-card:hover .snack-emoji { animation:wiggle .7s ease; }
            .snack-card:hover .price-tag { transform:rotate(3deg) scale(1.08); }
            .stat:hover { transform:translateY(-5px) rotate(-1deg); box-shadow:0 16px 28px -14px rgba(11,74,53,.35); }
        }

        .chip { transition:all .2s; white-space:nowrap; flex-shrink:0; }
        .chip.active { background:#0b4a35; color:#fff; border-color:#0b4a35; transform:scale(1.05); }

        @keyframes live { 0%{box-shadow:0 0 0 0 rgba(52,211,153,.8)} 100%{box-shadow:0 0 0 8px rgba(52,211,153,0)} }
        .live-dot { animation:live 1.6s infinite; }

        .toast-notification { animation:toastSlideIn .5s cubic-bezier(.2,.8,.2,1) forwards; }
        @keyframes toastSlideIn { 0%{opacity:0;transform:translateX(120%)} 100%{opacity:1;transform:translateX(0)} }
        .toast-hide { animation:toastSlideOut .4s ease forwards; }
        @keyframes toastSlideOut { 0%{opacity:1;transform:translateX(0)} 100%{opacity:0;transform:translateX(120%)} }
        .toast-progress { height:4px; width:100%; animation:toastProgress 4s linear forwards; }
        @keyframes toastProgress { from{width:100%} to{width:0%} }

        @keyframes pop-in { 0%{opacity:0;transform:scale(.85)} 100%{opacity:1;transform:scale(1)} }
        .pop-in { animation:pop-in .3s cubic-bezier(.2,.8,.2,1) both; }

        #search { transition:width .3s; font-size:16px; } /* 16px stops iOS zooming on focus */
        @media (min-width:640px){ #search { font-size:14px; } #search:focus { width:18rem; } }

        @media (prefers-reduced-motion:reduce){ *,*::before,*::after{animation:none!important;transition:none!important} .reveal{opacity:1;transform:none} }
    </style>
</head>

<body class="bg-gradient-to-b from-[#eef5ea] to-[#f7f9f4] min-h-screen">

    @php
        $totalSnacks       = $snacks->count();
        $availableSnacks   = $snacks->where('is_available', true)->count();
        $unavailableSnacks = $totalSnacks - $availableSnacks;
        $categories        = $snacks->pluck('category')->filter()->unique()->values();
    @endphp

    <!-- Header -->
    <header class="hero-bg relative overflow-hidden text-white shadow-lg">
        <div class="absolute -right-10 -top-16 w-64 h-64 rounded-full bg-[#f9c910]/15"></div>
        <div class="absolute -left-16 -bottom-20 w-56 h-56 rounded-full bg-white/5"></div>
        <span class="floaty absolute right-[28%] top-4 text-3xl opacity-40 hidden md:block">🍟</span>
        <span class="floaty absolute right-[18%] bottom-3 text-3xl opacity-40 hidden md:block" style="animation-delay:-2s">🍔</span>
        <span class="floaty absolute left-[48%] top-3 text-2xl opacity-30 hidden lg:block" style="animation-delay:-1s">☕</span>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-5 sm:py-6">

                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <div class="bob w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-[#f9c910] text-[#0b4a35] grid place-items-center text-2xl sm:text-3xl shadow-lg shrink-0">🍔</div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm text-white/70 flex flex-wrap items-center gap-x-2 gap-y-1">
                            Admin Panel
                            <span class="inline-flex items-center gap-1.5 bg-white/15 rounded-full px-2.5 py-0.5 text-[11px] font-semibold">
                                <span class="live-dot w-2 h-2 rounded-full bg-emerald-400"></span> Live menu
                            </span>
                        </p>
                        <h1 class="font-display text-2xl sm:text-4xl font-extrabold leading-none mt-1">Manage Snacks</h1>
                        <p class="text-xs sm:text-sm text-white/70 mt-1">Add and manage food items for students.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:flex gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.dashboard') }}"
                       class="ripple group min-h-[44px] flex items-center justify-center bg-white/10 border border-white/20 text-white text-sm sm:text-base font-semibold px-3 sm:px-4 py-2.5 rounded-xl hover:bg-white/20 transition active:scale-95">
                        <span class="inline-block transition-transform group-hover:-translate-x-1 mr-1">←</span> Dashboard
                    </a>
                    <a href="{{ route('admin.snacks.create') }}"
                       class="btn-shine ripple min-h-[44px] flex items-center justify-center bg-[#f9c910] text-[#0b4a35] text-sm sm:text-base font-bold px-3 sm:px-5 py-2.5 rounded-xl hover:bg-[#e6b800] transition hover:scale-105 active:scale-95">
                        + Add Snack
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <!-- Toasts -->
        @if(session('success'))
            <div id="successToast" class="toast-notification fixed top-3 left-3 right-3 sm:left-auto sm:top-5 sm:right-5 z-[9999] sm:w-[380px] bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden">
                <div class="p-4 flex items-start gap-3">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">✓</div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <p class="font-bold text-emerald-800 text-sm">Success</p>
                        <p class="text-gray-600 text-sm mt-1 leading-5 break-words">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="closeToast('successToast')" aria-label="Close" class="w-9 h-9 -mr-1 -mt-1 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition shrink-0">×</button>
                </div>
                <div class="toast-progress bg-emerald-500"></div>
            </div>
        @endif

        @if(session('error'))
            <div id="errorToast" class="toast-notification fixed top-3 left-3 right-3 sm:left-auto sm:top-5 sm:right-5 z-[9999] sm:w-[380px] bg-white rounded-2xl shadow-2xl border border-red-100 overflow-hidden">
                <div class="p-4 flex items-start gap-3">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl font-bold shrink-0">!</div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <p class="font-bold text-red-800 text-sm">Error</p>
                        <p class="text-gray-600 text-sm mt-1 leading-5 break-words">{{ session('error') }}</p>
                    </div>
                    <button type="button" onclick="closeToast('errorToast')" aria-label="Close" class="w-9 h-9 -mr-1 -mt-1 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition shrink-0">×</button>
                </div>
                <div class="toast-progress bg-red-500"></div>
            </div>
        @endif

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-6 sm:mb-8">
            <div class="stat rise bg-white border border-[#dfe8db] rounded-2xl p-3 sm:p-5 shadow-sm min-w-0">
                <div class="flex items-center justify-between gap-1">
                    <p class="text-[11px] sm:text-xs sm:uppercase sm:tracking-wide font-semibold text-gray-500 truncate">Total</p>
                    <span class="hidden sm:inline text-2xl">🍽️</span>
                </div>
                <p class="font-display font-extrabold text-2xl sm:text-4xl text-[#0b4a35] mt-1 sm:mt-2" data-count="{{ $totalSnacks }}">{{ $totalSnacks }}</p>
            </div>
            <div class="stat rise bg-emerald-50 border border-[#dfe8db] rounded-2xl p-3 sm:p-5 shadow-sm min-w-0" style="animation-delay:.08s">
                <div class="flex items-center justify-between gap-1">
                    <p class="text-[11px] sm:text-xs sm:uppercase sm:tracking-wide font-semibold text-emerald-800/70 truncate">Available</p>
                    <span class="hidden sm:inline text-2xl">🟢</span>
                </div>
                <p class="font-display font-extrabold text-2xl sm:text-4xl text-emerald-800 mt-1 sm:mt-2" data-count="{{ $availableSnacks }}">{{ $availableSnacks }}</p>
            </div>
            <div class="stat rise bg-red-50 border border-[#dfe8db] rounded-2xl p-3 sm:p-5 shadow-sm min-w-0" style="animation-delay:.16s">
                <div class="flex items-center justify-between gap-1">
                    <p class="text-[11px] sm:text-xs sm:uppercase sm:tracking-wide font-semibold text-red-800/70 truncate">Unavailable</p>
                    <span class="hidden sm:inline text-2xl">🔴</span>
                </div>
                <p class="font-display font-extrabold text-2xl sm:text-4xl text-red-800 mt-1 sm:mt-2" data-count="{{ $unavailableSnacks }}">{{ $unavailableSnacks }}</p>
            </div>
        </div>

        <!-- Title + search + filters -->
        <div class="rise mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4" style="animation-delay:.2s">
            <div>
                <h2 class="font-display text-xl sm:text-3xl font-extrabold text-[#0b4a35] leading-none">Food Items</h2>
                <p class="text-gray-500 mt-1 text-xs sm:text-sm">These food items will be displayed on the student food page.</p>
            </div>

            @if($snacks->count() > 0)
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 min-w-0">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
                        <input id="search" type="search" placeholder="Search snacks"
                               class="w-full sm:w-56 rounded-full border border-gray-200 bg-white pl-9 pr-4 py-3 sm:py-2.5 focus:outline-none focus:border-[#0b4a35] focus:ring-4 focus:ring-[#f9c910]/40">
                    </div>
                    <!-- Scrolls sideways on phones, wraps on larger screens -->
                    <div class="no-scrollbar flex gap-2 overflow-x-auto -mx-4 px-4 py-1 sm:mx-0 sm:px-0 sm:overflow-visible sm:flex-wrap">
                        <button type="button" data-avail="all" class="chip active ripple border border-gray-200 bg-white text-sm font-semibold px-4 py-2.5 sm:py-2 rounded-full">All</button>
                        <button type="button" data-avail="1" class="chip ripple border border-gray-200 bg-white text-sm font-semibold px-4 py-2.5 sm:py-2 rounded-full">🟢 Available</button>
                        <button type="button" data-avail="0" class="chip ripple border border-gray-200 bg-white text-sm font-semibold px-4 py-2.5 sm:py-2 rounded-full">🔴 Unavailable</button>
                    </div>
                </div>
            @endif
        </div>

        @if($categories->count() > 0)
            <div class="rise no-scrollbar flex gap-2 overflow-x-auto -mx-4 px-4 py-1 mb-5 sm:mx-0 sm:px-0 sm:overflow-visible sm:flex-wrap sm:mb-6" style="animation-delay:.25s">
                <button type="button" data-cat="all" class="cat-chip chip active ripple border border-gray-200 bg-white text-xs font-semibold px-3.5 py-2 sm:py-1.5 rounded-full">All categories</button>
                @foreach($categories as $cat)
                    <button type="button" data-cat="{{ strtolower($cat) }}" class="cat-chip chip ripple border border-gray-200 bg-white text-xs font-semibold px-3.5 py-2 sm:py-1.5 rounded-full">{{ $cat }}</button>
                @endforeach
            </div>
        @endif

        <!-- Snacks -->
        @if($snacks->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">

                @foreach($snacks as $snack)

                    <div class="snack-card reveal bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col"
                         data-name="{{ strtolower($snack->name) }}"
                         data-avail="{{ $snack->is_available ? 1 : 0 }}"
                         data-cat="{{ strtolower($snack->category ?? '') }}"
                         style="transition-delay: {{ ($loop->index % 4) * 0.08 }}s">

                        <!-- Image -->
                        <div class="relative h-44 sm:h-48 bg-gradient-to-br from-[#eef5ea] to-[#FFF6D6] overflow-hidden">

                            @if($snack->image)
                                <img src="{{ asset('storage/' . $snack->image) }}" alt="{{ $snack->name }}" loading="lazy"
                                     class="snack-img w-full h-full object-cover {{ $snack->is_available ? '' : 'grayscale opacity-70' }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl">
                                    <span class="snack-emoji">🍛</span>
                                </div>
                            @endif

                            <!-- Availability badge -->
                            <div class="absolute top-3 left-3">
                                @if($snack->is_available)
                                    <span class="inline-flex items-center gap-1.5 bg-white/95 text-green-700 text-xs font-bold px-3 py-1 rounded-full shadow">
                                        <span class="live-dot w-2 h-2 rounded-full bg-emerald-500"></span> Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-white/95 text-red-700 text-xs font-bold px-3 py-1 rounded-full shadow">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Unavailable
                                    </span>
                                @endif
                            </div>

                            <!-- ID -->
                            <span class="absolute top-3 right-3 bg-black/40 text-white text-xs px-2.5 py-1 rounded-full backdrop-blur">#{{ $snack->id }}</span>

                            <!-- Price tag -->
                            <div class="price-tag absolute bottom-3 right-3 bg-[#f9c910] text-[#0b4a35] font-display font-extrabold text-lg sm:text-xl px-3 sm:px-3.5 py-1 rounded-xl shadow-lg">
                                ₹{{ number_format($snack->price, 2) }}
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 sm:p-5 flex flex-col flex-1">

                            @if($snack->category)
                                <span class="self-start bg-[#fff6d6] text-[#8a5b12] text-xs font-semibold px-3 py-1 rounded-full mb-3">
                                    {{ $snack->category }}
                                </span>
                            @endif

                            <h3 class="font-display text-lg sm:text-xl font-extrabold text-[#0b4a35] leading-tight break-words">{{ $snack->name }}</h3>

                            <p class="text-sm text-gray-500 mt-2 sm:min-h-[40px] break-words">
                                {{ $snack->description ?: 'No description available.' }}
                            </p>

                            <!-- Actions -->
                            <div class="flex gap-2 mt-auto pt-4 sm:pt-5">
                                <a href="{{ route('admin.snacks.edit', $snack) }}"
                                   class="ripple flex-1 min-h-[44px] flex items-center justify-center bg-blue-600 text-white text-sm sm:text-base font-semibold px-3 py-2.5 rounded-xl hover:bg-blue-700 transition hover:scale-[1.03] active:scale-95">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('admin.snacks.toggleAvailability', $snack) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="ripple w-full min-h-[44px] bg-gray-100 text-gray-700 text-sm sm:text-base font-semibold px-3 py-2.5 rounded-xl hover:bg-gray-200 transition hover:scale-[1.03] active:scale-95">
                                        @if($snack->is_available) 🔴 Disable @else 🟢 Enable @endif
                                    </button>
                                </form>
                            </div>

                            <!-- Delete -->
                            <form action="{{ route('admin.snacks.destroy', $snack) }}" method="POST" class="mt-2 delete-form" data-name="{{ $snack->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full min-h-[44px] bg-red-50 text-red-600 text-sm sm:text-base font-semibold px-3 py-2.5 rounded-xl hover:bg-red-600 hover:text-white transition active:scale-95">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>

                @endforeach
            </div>

            <!-- No match -->
            <div id="noMatch" class="hidden bg-white border border-gray-200 rounded-2xl shadow-sm p-8 sm:p-10 text-center mt-2">
                <div class="bob text-5xl">🔎</div>
                <h3 class="font-display text-xl font-extrabold text-[#0b4a35] mt-3">No snacks match</h3>
                <p class="text-gray-500 text-sm mt-1">Try a different search or filter.</p>
            </div>

        @else

            <!-- Empty State -->
            <div class="rise bg-white border border-gray-200 rounded-2xl shadow-sm p-8 sm:p-10 text-center">
                <div class="text-6xl animate-bounce">🍽️</div>
                <h3 class="font-display text-xl sm:text-2xl font-extrabold text-[#0b4a35] mt-4">No Snacks Added</h3>
                <p class="text-gray-500 mt-2 text-sm sm:text-base">Add your first food item for students.</p>
                <a href="{{ route('admin.snacks.create') }}"
                   class="pulse-ring btn-shine ripple inline-flex items-center justify-center min-h-[44px] mt-5 bg-[#f9c910] text-[#0b4a35] font-bold px-6 py-3 rounded-xl hover:bg-[#e6b800] transition hover:scale-105 active:scale-95">
                    + Add First Snack
                </a>
            </div>

        @endif

    </main>

    <!-- Delete confirm modal -->
    <div id="deleteModal" class="hidden fixed inset-0 z-[100] items-center justify-center p-4 overflow-y-auto bg-[#06301f]/70 backdrop-blur-sm"
         onclick="if(event.target===this) closeDelete()">
        <div class="pop-in w-full max-w-sm bg-white rounded-3xl p-5 sm:p-7 text-center shadow-2xl my-auto">
            <div class="bob w-14 h-14 sm:w-16 sm:h-16 mx-auto rounded-2xl bg-red-50 grid place-items-center text-3xl sm:text-4xl">🗑️</div>
            <h3 class="font-display font-extrabold text-xl sm:text-2xl text-[#0b4a35] mt-4">Delete this item?</h3>
            <p class="text-sm text-gray-500 mt-1 break-words">
                <b id="deleteName" class="text-[#0b4a35]"></b> will be removed from the student food page.
            </p>
            <div class="flex flex-col-reverse sm:flex-row gap-2 sm:gap-3 mt-6">
                <button type="button" onclick="closeDelete()" class="sm:flex-1 min-h-[44px] py-3 rounded-xl bg-[#eef5ea] text-[#0b4a35] font-semibold hover:bg-[#dfeadb] transition">Keep it</button>
                <button type="button" id="deleteConfirm" class="sm:flex-1 min-h-[44px] py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition active:scale-95">Yes, delete</button>
            </div>
        </div>
    </div>

    <script>
        // Count-up
        document.querySelectorAll('[data-count]').forEach(el => {
            const target = parseInt(el.dataset.count, 10) || 0;
            if (!target) return;
            let n = 0; const step = Math.max(1, Math.ceil(target / 25));
            el.textContent = 0;
            const t = setInterval(() => { n = Math.min(target, n + step); el.textContent = n; if (n >= target) clearInterval(t); }, 35);
        });

        // Scroll reveal
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // Ripple (works for mouse and touch taps)
        document.addEventListener('click', e => {
            const btn = e.target.closest('.ripple');
            if (!btn) return;
            const r = btn.getBoundingClientRect(), size = Math.max(r.width, r.height);
            const w = document.createElement('span');
            w.className = 'ripple-wave';
            w.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - r.left - size/2}px;top:${e.clientY - r.top - size/2}px`;
            btn.appendChild(w);
            setTimeout(() => w.remove(), 600);
        });

        // Search + availability + category filter
        const cards  = document.querySelectorAll('.snack-card');
        const search = document.getElementById('search');
        const noMatch = document.getElementById('noMatch');
        let avail = 'all', cat = 'all';

        function apply() {
            const q = (search?.value || '').trim().toLowerCase();
            let shown = 0;
            cards.forEach(c => {
                const ok = c.dataset.name.includes(q)
                    && (avail === 'all' || c.dataset.avail === avail)
                    && (cat === 'all' || c.dataset.cat === cat);
                c.classList.toggle('hidden', !ok);
                if (ok) { shown++; c.classList.add('in'); }
            });
            noMatch?.classList.toggle('hidden', shown !== 0);
        }
        search?.addEventListener('input', apply);

        // Keep the tapped chip visible inside its scrolling row on phones
        const reveal = el => el.scrollIntoView({ behavior:'smooth', inline:'center', block:'nearest' });

        document.querySelectorAll('[data-avail].chip').forEach(b => b.addEventListener('click', () => {
            document.querySelectorAll('[data-avail].chip').forEach(x => x.classList.remove('active'));
            b.classList.add('active'); avail = b.dataset.avail; apply(); reveal(b);
        }));
        document.querySelectorAll('.cat-chip').forEach(b => b.addEventListener('click', () => {
            document.querySelectorAll('.cat-chip').forEach(x => x.classList.remove('active'));
            b.classList.add('active'); cat = b.dataset.cat; apply(); reveal(b);
        }));

        // Delete modal
        const dModal = document.getElementById('deleteModal');
        let pendingForm = null;
        document.querySelectorAll('.delete-form').forEach(f => f.addEventListener('submit', e => {
            e.preventDefault();
            pendingForm = f;
            document.getElementById('deleteName').textContent = f.dataset.name;
            dModal.classList.remove('hidden'); dModal.classList.add('flex');
        }));
        function closeDelete() { dModal.classList.add('hidden'); dModal.classList.remove('flex'); pendingForm = null; }
        document.getElementById('deleteConfirm').addEventListener('click', () => { if (pendingForm) pendingForm.submit(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDelete(); });

        // Toast
        function closeToast(id) {
            const t = document.getElementById(id);
            if (!t) return;
            t.classList.add('toast-hide');
            setTimeout(() => t.remove(), 400);
        }
        setTimeout(() => { closeToast('successToast'); closeToast('errorToast'); }, 4000);
    </script>

</body>
</html>
