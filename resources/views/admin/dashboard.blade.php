<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Poppins:wght@400;500;600&family=IBM+Plex+Mono:wght@500;600&display=swap');

        .od { font-family:'Poppins',sans-serif; }
        .font-display { font-family:'Baloo 2',cursive; }
        .font-ticket { font-family:'IBM Plex Mono',ui-monospace,monospace; }

        .perf { background-image:radial-gradient(circle,#e8f0e4 3px,transparent 3.5px); background-size:14px 2px; background-repeat:repeat-x; }

        /* ---------- entrance / scroll reveal ---------- */
        @keyframes rise { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }
        .rise { animation:rise .55s cubic-bezier(.2,.8,.2,1) both; }

        .reveal { opacity:0; transform:translateY(28px) scale(.97); transition:opacity .6s cubic-bezier(.2,.8,.2,1), transform .6s cubic-bezier(.2,.8,.2,1); }
        .reveal.in { opacity:1; transform:none; }

        /* ---------- header ---------- */
        @keyframes gradient-move { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .hero-bg { background:linear-gradient(120deg,#0b4a35,#06301f,#0f6b4b,#06301f); background-size:300% 300%; animation:gradient-move 14s ease infinite; }

        @keyframes floaty { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-12px) rotate(8deg)} }
        .floaty { animation:floaty 5s ease-in-out infinite; }

        @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        .bob { animation:bob 2.4s ease-in-out infinite; }

        /* ---------- snack marquee ---------- */
        @keyframes marquee { from{transform:translateX(0)} to{transform:translateX(-50%)} }
        .marquee-track { display:flex; width:max-content; animation:marquee 28s linear infinite; }
        .marquee:hover .marquee-track { animation-play-state:paused; }

        /* ---------- live dot ---------- */
        @keyframes live { 0%{box-shadow:0 0 0 0 rgba(52,211,153,.8)} 100%{box-shadow:0 0 0 10px rgba(52,211,153,0)} }
        .live-dot { animation:live 1.6s infinite; }

        @keyframes pulse-ring { 0%{box-shadow:0 0 0 0 rgba(249,201,16,.7)} 100%{box-shadow:0 0 0 14px rgba(249,201,16,0)} }
        .pulse-ring { animation:pulse-ring 1.8s infinite; }

        /* ---------- buttons ---------- */
        @keyframes shine { to{transform:translateX(250%) skewX(-20deg)} }
        .btn-shine { position:relative; overflow:hidden; }
        .btn-shine::after { content:'';position:absolute;inset:0 auto 0 -60%;width:40%;background:rgba(255,255,255,.55);transform:skewX(-20deg);animation:shine 3.2s ease-in-out infinite; }

        .ripple { position:relative; overflow:hidden; }
        .ripple-wave { position:absolute; border-radius:9999px; background:rgba(255,255,255,.5); transform:scale(0); animation:ripple .6s linear; pointer-events:none; }
        @keyframes ripple { to{transform:scale(4);opacity:0} }

        @keyframes spin-once { to{transform:rotate(360deg)} }
        .spin-once { animation:spin-once .7s ease; }

        /* ---------- stat cards ---------- */
        .stat { transition:transform .25s, box-shadow .25s; }
        .stat:hover { transform:translateY(-6px) rotate(-1deg); box-shadow:0 18px 30px -14px rgba(11,74,53,.35); }
        .stat:hover .stat-emoji { animation:wiggle .6s ease; }
        .stat.active { outline:3px solid #f9c910; outline-offset:2px; transform:translateY(-3px); }

        @keyframes wiggle { 0%,100%{transform:rotate(0)} 20%{transform:rotate(-18deg) scale(1.15)} 40%{transform:rotate(14deg) scale(1.15)} 60%{transform:rotate(-10deg)} 80%{transform:rotate(6deg)} }

        /* ---------- KOT cards ---------- */
        .kot-card { transition:transform .25s, box-shadow .25s; }
        .kot-card:hover { transform:translateY(-6px); box-shadow:0 18px 34px -14px rgba(11,74,53,.4); }

        .kot-card .status-bar { background-size:200% 100%; animation:bar-slide 3s linear infinite; }
        @keyframes bar-slide { to{background-position:-200% 0} }

        .item-row { transition:transform .2s, background .2s; }
        .item-row:hover { transform:translateX(6px); background:#FFF6D6; }

        /* Ready bell ring */
        @keyframes ring { 0%,100%{transform:rotate(0)} 10%,30%,50%{transform:rotate(-16deg)} 20%,40%,60%{transform:rotate(16deg)} 70%{transform:rotate(0)} }
        .bell { display:inline-block; transform-origin:top center; animation:ring 2.6s ease-in-out infinite; }

        /* Chef cooking */
        @keyframes cook { 0%,100%{transform:translateY(0) rotate(0)} 50%{transform:translateY(-3px) rotate(-8deg)} }
        .chef { display:inline-block; animation:cook 1s ease-in-out infinite; }

        /* Progress step pop-in */
        @keyframes pop { 0%{transform:scale(0)} 70%{transform:scale(1.25)} 100%{transform:scale(1)} }
        .step-dot { animation:pop .5s cubic-bezier(.2,.8,.2,1) both; }

        .perk-ring { box-shadow:0 0 0 0 rgba(249,201,16,.6); animation:pulse-ring 2s infinite; }

        /* Manage snacks big button */
        .snack-cta { background:linear-gradient(110deg,#f9c910 0%,#ffe27a 45%,#f9c910 100%); background-size:200% 100%; transition:background-position .6s, transform .2s, box-shadow .2s; }
        .snack-cta:hover { background-position:100% 0; transform:translateY(-3px); box-shadow:0 14px 26px -10px rgba(249,201,16,.8); }
        .snack-cta:hover .cta-emoji { animation:wiggle .6s ease; }

        /* Search focus */
        #search { transition:width .3s, box-shadow .3s; }
        @media (min-width:640px){ #search:focus { width:18rem; } }

        @media (prefers-reduced-motion:reduce){ *,*::before,*::after{animation:none!important;transition:none!important} .reveal{opacity:1;transform:none} }
    </style>

    @php
        $logoutRoute = Route::has('admin.logout') ? 'admin.logout' : 'logout';
        $adminName   = auth()->user()->name ?? 'Admin';
        $awaiting    = $orders->where('payment_status', 'submitted')->count();

        $kitchen = [
            'pending'   => ['label' => 'Pending',          'bar' => 'from-gray-300 via-gray-400 to-gray-300',          'badge' => 'bg-gray-100 text-gray-600',      'emoji' => '🕐'],
            'preparing' => ['label' => 'Preparing',        'bar' => 'from-[#f9c910] via-[#ffe27a] to-[#f9c910]',       'badge' => 'bg-[#FFF6D6] text-[#8A5B12]',    'emoji' => '<span class="chef">👨‍🍳</span>'],
            'ready'     => ['label' => 'Ready for pickup', 'bar' => 'from-sky-400 via-sky-300 to-sky-400',             'badge' => 'bg-sky-50 text-sky-800',         'emoji' => '<span class="bell">🔔</span>'],
            'completed' => ['label' => 'Completed',        'bar' => 'from-emerald-500 via-emerald-400 to-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-800', 'emoji' => '✅'],
        ];
        $steps = ['pending', 'preparing', 'ready', 'completed'];

        // label, value, emoji, filter, card classes
        $stats = [
            ['Total Orders', $totalOrders,     '🧾', 'all',       'bg-white text-[#0b4a35]'],
            ['Pending',      $pendingOrders,   '🕐', 'pending',   'bg-white text-gray-700'],
            ['Preparing',    $preparingOrders, '👨‍🍳', 'preparing', 'bg-[#FFF6D6] text-[#8A5B12]'],
            ['Ready',        $readyOrders,     '🔔', 'ready',     'bg-sky-50 text-sky-800'],
            ['Completed',    $completedOrders, '✅', 'completed', 'bg-emerald-50 text-emerald-800'],
        ];

        $marquee = ['🍔 Burgers','🍟 Fries','☕ Coffee','🍛 Meals','🥪 Sandwiches','🍕 Pizza','🧋 Cool drinks','🍩 Sweets','🌮 Rolls','🍜 Noodles'];
    @endphp

    <div class="od min-h-screen bg-gradient-to-b from-[#eef5ea] to-[#f7f9f4]">

        {{-- ============ TOP BAR ============ --}}
        <div class="hero-bg relative overflow-hidden text-white">
            <div class="absolute -right-10 -top-16 w-64 h-64 rounded-full bg-[#f9c910]/15"></div>
            <div class="absolute -left-16 -bottom-20 w-56 h-56 rounded-full bg-white/5"></div>
            <span class="floaty absolute right-[26%] top-4 text-3xl opacity-40 hidden md:block">🍛</span>
            <span class="floaty absolute right-[15%] bottom-3 text-3xl opacity-40 hidden md:block" style="animation-delay:-2s">☕</span>
            <span class="floaty absolute left-[42%] top-3 text-2xl opacity-30 hidden lg:block" style="animation-delay:-1s">🍟</span>
            <span class="floaty absolute left-[55%] bottom-2 text-2xl opacity-30 hidden lg:block" style="animation-delay:-3s">🍔</span>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="bob w-12 h-12 rounded-2xl bg-[#f9c910] text-[#0b4a35] grid place-items-center text-2xl shadow-lg shrink-0">🍽️</div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/70"><span id="greet">Hello</span>, <span class="font-semibold text-[#f9c910]">{{ $adminName }}</span> 👋</p>
                        <div class="flex items-center gap-2">
                            <h2 class="font-display font-extrabold text-2xl sm:text-3xl leading-none truncate">Order Desk</h2>
                            <span class="hidden sm:inline-flex items-center gap-1.5 bg-white/15 rounded-full px-2.5 py-0.5 text-[11px] font-semibold">
                                <span class="live-dot w-2 h-2 rounded-full bg-emerald-400"></span> Live
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <div class="hidden md:block text-right leading-tight">
                        <p id="clock" class="font-ticket text-lg font-semibold"></p>
                        <p id="date" class="text-xs text-white/70"></p>
                    </div>

                    <button type="button" id="refreshBtn" title="Refresh orders"
                            class="ripple w-10 h-10 grid place-items-center rounded-xl bg-white/15 hover:bg-white/25 ring-1 ring-white/30 transition active:scale-90">
                        <svg id="refreshIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M5.6 9A8 8 0 0119 11M18.4 15A8 8 0 015 13"/>
                        </svg>
                    </button>

                    <button type="button" onclick="openLogout()"
                            class="ripple group inline-flex items-center gap-2 bg-white/15 hover:bg-red-600 ring-1 ring-white/30 text-white font-semibold
                                   px-3 sm:px-4 py-2.5 rounded-xl text-sm transition-colors duration-200 active:scale-95">
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </div>
            </div>

            {{-- Snack ticker --}}
            <div class="marquee relative border-t border-white/10 bg-black/15 overflow-hidden">
                <div class="marquee-track py-2 text-sm text-white/80">
                    @for($r = 0; $r < 2; $r++)
                        @foreach($marquee as $m)
                            <span class="mx-6 whitespace-nowrap font-medium">{{ $m }}</span>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- ================= TOAST NOTIFICATIONS ================= --}}
            @if(session('success'))
                <div id="successToast"
                     class="toast-notification fixed top-5 right-5 z-[9999] w-[380px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-emerald-100 overflow-hidden">
                    <div class="p-4 flex items-start gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">✓</div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="font-bold text-emerald-800 text-sm">Success</p>
                            <p class="text-gray-600 text-sm mt-1 leading-5">{{ session('success') }}</p>
                        </div>
                        <button type="button" onclick="closeToast('successToast')"
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition shrink-0">×</button>
                    </div>
                    <div class="toast-progress success-progress"></div>
                </div>
            @endif

            @if(session('error'))
                <div id="errorToast"
                     class="toast-notification fixed top-5 right-5 z-[9999] w-[380px] max-w-[calc(100vw-2rem)] bg-white rounded-2xl shadow-2xl border border-red-100 overflow-hidden">
                    <div class="p-4 flex items-start gap-3">
                        <div class="w-11 h-11 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl font-bold shrink-0">!</div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="font-bold text-red-800 text-sm">Error</p>
                            <p class="text-gray-600 text-sm mt-1 leading-5">{{ session('error') }}</p>
                        </div>
                        <button type="button" onclick="closeToast('errorToast')"
                                class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition shrink-0">×</button>
                    </div>
                    <div class="toast-progress error-progress"></div>
                </div>
            @endif

            <style>
                .toast-notification { animation: toastSlideIn .5s cubic-bezier(.2,.8,.2,1) forwards; }
                @keyframes toastSlideIn { 0%{opacity:0;transform:translateX(120%)} 100%{opacity:1;transform:translateX(0)} }
                .toast-hide { animation: toastSlideOut .4s ease forwards; }
                @keyframes toastSlideOut { 0%{opacity:1;transform:translateX(0)} 100%{opacity:0;transform:translateX(120%)} }
                .toast-progress { height:4px; width:100%; animation: toastProgress 4s linear forwards; }
                .success-progress { background:#10b981; }
                .error-progress { background:#ef4444; }
                @keyframes toastProgress { from{width:100%} to{width:0%} }
                @media (max-width:640px){ .toast-notification{ top:1rem; right:1rem; left:1rem; width:auto; max-width:none; } }
            </style>

            {{-- Needs attention banner --}}
            @if($awaiting > 0)
                <div class="rise mb-6 flex items-center gap-3 bg-[#FFF6D6] border border-[#f9c910] text-[#8A5B12] px-5 py-3 rounded-xl">
                    <span class="pulse-ring w-3 h-3 rounded-full bg-[#f9c910]"></span>
                    <p class="text-sm font-medium"><b>{{ $awaiting }}</b> payment(s) waiting for your verification.</p>
                </div>
            @endif

            {{-- STATS (click to filter) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                @foreach($stats as $i => $s)
                    <button type="button" data-filter="{{ $s[3] }}"
                            class="stat rise text-left rounded-2xl {{ $s[4] }} border border-[#dfe8db] p-5 shadow-sm {{ $i === 0 ? 'active col-span-2 sm:col-span-1' : '' }}"
                            style="animation-delay: {{ $i * 0.08 }}s">
                        <div class="flex items-center justify-between">
                            <p class="text-xs uppercase tracking-wide font-semibold opacity-70">{{ $s[0] }}</p>
                            <span class="stat-emoji text-2xl">{{ $s[2] }}</span>
                        </div>
                        <p class="font-display font-extrabold text-4xl mt-2" data-count="{{ $s[1] }}">{{ $s[1] }}</p>
                    </button>
                @endforeach
            </div>

            {{-- QUICK ACTION (single button) --}}
            <div class="rise mb-8" style="animation-delay:.3s">
                <a href="{{ route('admin.snacks.index') }}"
                   class="snack-cta ripple group flex items-center justify-between gap-4 rounded-2xl px-5 sm:px-6 py-4 text-[#0b4a35] shadow-sm">
                    <span class="flex items-center gap-4">
                        <span class="cta-emoji w-12 h-12 rounded-xl bg-white/70 grid place-items-center text-2xl">🍔</span>
                        <span>
                            <span class="block font-display font-extrabold text-xl leading-none">Manage Snacks</span>
                            <span class="block text-sm opacity-80 mt-1">Add, edit or remove items from the menu</span>
                        </span>
                    </span>
                    <span class="w-10 h-10 rounded-full bg-[#0b4a35] text-white grid place-items-center text-lg transition-transform group-hover:translate-x-1.5">→</span>
                </a>
            </div>

            {{-- VERIFY KOT --}}
            <div class="reveal relative bg-white rounded-2xl p-5 sm:p-6 mb-8 shadow-sm border border-[#dfe8db]">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div class="flex items-center gap-4">
                        <div class="pulse-ring bob w-12 h-12 rounded-xl bg-[#f9c910] text-[#0b4a35] grid place-items-center text-2xl">🎫</div>
                        <div>
                            <h3 class="font-display font-extrabold text-xl text-[#0b4a35] leading-none">Verify a KOT</h3>
                            <p class="text-sm text-gray-500 mt-1">Enter the number printed on the student's ticket.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.orders.verify') }}" method="POST" class="w-full lg:max-w-xl flex flex-col sm:flex-row gap-3">
                        @csrf
                        <div class="relative flex-1">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-ticket font-semibold text-gray-400">KOT</span>
                            <input type="text" name="kot_number" placeholder="e.g. KOT-0248" required
                                   class="font-ticket w-full rounded-xl border-gray-200 bg-[#f7f9f4] text-[#06301f] placeholder:text-gray-400
                                          focus:border-[#0b4a35] focus:ring-4 focus:ring-[#f9c910]/50 pl-14 pr-4 py-3">
                        </div>
                        <button type="submit"
                                class="btn-shine ripple inline-flex items-center justify-center gap-2 bg-[#0b4a35] hover:bg-[#06301f] text-white
                                       font-bold px-7 py-3 rounded-xl transition hover:scale-105 active:scale-95 whitespace-nowrap">
                            Verify KOT →
                        </button>
                    </form>
                </div>
            </div>

            {{-- ORDERS --}}
            <div class="reveal bg-white rounded-2xl overflow-hidden border border-[#dfe8db] shadow-sm">

                <div class="p-5 sm:p-6 border-b border-[#eef2ea] flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h3 class="font-display font-extrabold text-2xl text-[#0b4a35] leading-none">All Orders</h3>
                        <p class="text-sm text-gray-500 mt-1">Verify payment, then move each order through the kitchen.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
                            <input id="search" type="search" placeholder="Search KOT or student"
                                   class="w-full sm:w-56 rounded-full border-gray-200 bg-[#f7f9f4] text-sm pl-9 pr-4 py-2 focus:border-[#0b4a35] focus:ring-[#f9c910]">
                        </div>
                        <span class="font-ticket text-sm text-gray-400"><span id="visibleCount">{{ $orders->count() }}</span> / {{ $orders->count() }} ticket(s)</span>
                    </div>
                </div>

                @if($orders->count() > 0)

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 p-5 sm:p-6 bg-[#f7f9f4]">

                        @foreach($orders as $order)
                            @php
                                $k = $kitchen[$order->status] ?? $kitchen['pending'];
                                $current = array_search($order->status, $steps);
                            @endphp

                            <div class="kot-card reveal bg-white border rounded-2xl overflow-hidden shadow-sm
                                        {{ $order->payment_status === 'submitted' ? 'border-[#f9c910] ring-2 ring-[#f9c910]/40' : 'border-[#dfe8db]' }}"
                                 data-status="{{ $order->status }}"
                                 data-search="{{ strtolower($order->kot_number . ' ' . ($order->user->name ?? '')) }}"
                                 style="transition-delay: {{ min($loop->index % 6, 5) * 0.07 }}s">

                                <div class="status-bar h-1.5 bg-gradient-to-r {{ $k['bar'] }}"></div>

                                {{-- Header --}}
                                <div class="p-5 bg-gradient-to-br from-[#eef5ea] to-white">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">KOT Number</p>
                                            <h4 class="font-ticket text-xl font-semibold text-[#0b4a35] mt-0.5">{{ $order->kot_number }}</h4>
                                            <p class="text-sm text-gray-700 mt-2 flex items-center gap-1.5">
                                                <span class="w-6 h-6 rounded-full bg-[#f9c910] text-[#0b4a35] text-xs font-bold grid place-items-center">
                                                    {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                                </span>
                                                <span class="truncate">{{ $order->user->name ?? 'Unknown student' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-400 truncate">{{ $order->user->email ?? 'Unknown email' }}</p>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">Total</p>
                                            <p class="font-display font-extrabold text-2xl text-[#0b4a35] leading-none mt-1">₹{{ number_format($order->total_amount, 2) }}</p>
                                            <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $k['badge'] }}">{!! $k['emoji'] !!} {{ $k['label'] }}</span>
                                        </div>
                                    </div>

                                    {{-- Progress --}}
                                    <div class="flex items-center mt-5">
                                        @foreach($steps as $idx => $st)
                                            <div class="flex items-center {{ $loop->last ? '' : 'flex-1' }}">
                                                <span title="{{ ucfirst($st) }}"
                                                      style="animation-delay: {{ $idx * 0.12 }}s"
                                                      class="step-dot w-7 h-7 rounded-full grid place-items-center text-xs shrink-0
                                                             {{ $current !== false && $idx <= $current ? 'bg-[#0b4a35] text-white' : 'bg-gray-200 text-gray-400' }}
                                                             {{ $idx === $current ? 'ring-4 ring-[#f9c910]/60 perk-ring' : '' }}">
                                                    {{ $idx < $current ? '✓' : $idx + 1 }}
                                                </span>
                                                @unless($loop->last)
                                                    <span class="flex-1 h-1 mx-1 rounded {{ $current !== false && $idx < $current ? 'bg-[#0b4a35]' : 'bg-gray-200' }}"></span>
                                                @endunless
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Payment --}}
                                <div class="p-5 border-t border-[#eef2ea]">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="font-bold text-[#0b4a35] text-sm">💳 Payment</h5>
                                        @if($order->payment_status === 'confirmed')
                                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-semibold">Confirmed</span>
                                        @elseif($order->payment_status === 'rejected')
                                            <span class="px-3 py-1 rounded-full bg-red-50 text-red-800 text-xs font-semibold">Rejected</span>
                                        @elseif($order->payment_status === 'submitted')
                                            <span class="px-3 py-1 rounded-full bg-[#FFF6D6] text-[#8A5B12] text-xs font-semibold animate-pulse">Awaiting verification</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">Pending</span>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="min-w-0">
                                            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">UTR / Txn ID</p>
                                            @if($order->payment_reference)
                                                <p class="font-ticket text-sm font-medium text-[#06301f] mt-1 break-all">{{ $order->payment_reference }}</p>
                                            @else
                                                <p class="text-sm text-gray-300 mt-1">Not submitted</p>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">Confirmed at</p>
                                            @if($order->payment_paid_at)
                                                <p class="text-sm font-medium text-[#06301f] mt-1">{{ $order->payment_paid_at->format('d M Y, h:i A') }}</p>
                                            @else
                                                <p class="text-sm text-gray-300 mt-1">Not confirmed</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="perf h-[2px] mx-5"></div>

                                {{-- Items --}}
                                <div class="p-5">
                                    <h5 class="font-bold text-[#0b4a35] text-sm mb-3">🍛 Items</h5>
                                    <div class="space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="item-row flex justify-between items-center gap-3 bg-[#f7f9f4] rounded-xl px-3 py-2.5">
                                                <div class="min-w-0">
                                                    <p class="font-medium text-[#06301f] truncate">{{ $item->snack->name ?? 'Food item' }}</p>
                                                    <p class="text-xs text-gray-400">Qty {{ $item->quantity }}</p>
                                                </div>
                                                <p class="font-ticket text-sm font-medium text-[#06301f] whitespace-nowrap">₹{{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="p-5 border-t border-[#eef2ea] bg-[#fafcf8]">
                                    @if($order->payment_status === 'submitted')
                                        <a href="{{ route('admin.orders.verify-payment', $order) }}"
                                           class="btn-shine ripple block text-center bg-[#0b4a35] hover:bg-[#06301f] text-white font-semibold px-4 py-3
                                                  rounded-xl text-sm transition hover:scale-[1.02] active:scale-95 mb-3">
                                            ✔ Verify Payment
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="flex-1 rounded-xl border-gray-200 text-sm focus:border-[#f9c910] focus:ring-[#f9c910]">
                                            <option value="pending"   @selected($order->status === 'pending')>Pending</option>
                                            <option value="preparing" @selected($order->status === 'preparing')>Preparing</option>
                                            <option value="ready"     @selected($order->status === 'ready')>Ready</option>
                                            <option value="completed" @selected($order->status === 'completed')>Completed</option>
                                        </select>
                                        <button type="submit"
                                                class="ripple bg-[#f9c910] hover:bg-[#e6b800] text-[#06301f] font-bold px-5 py-3 rounded-xl text-sm transition hover:scale-105 active:scale-95">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="filterEmpty" class="hidden p-14 text-center">
                        <p class="text-5xl bob">🍽️</p>
                        <p class="font-display font-bold text-xl text-[#0b4a35] mt-3">No tickets found</p>
                        <p class="text-sm text-gray-400 mt-1">Try a different filter or search.</p>
                    </div>

                @else
                    <div class="p-14 text-center">
                        <p class="text-6xl animate-bounce">🍽️</p>
                        <h3 class="font-display font-extrabold text-2xl text-[#0b4a35] mt-4">Nothing on the rail yet</h3>
                        <p class="text-gray-400 mt-2">New orders will show up here as students place them.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- LOGOUT MODAL --}}
    <div id="logoutModal" class="od hidden fixed inset-0 z-[100] items-center justify-center p-4 bg-[#06301f]/70 backdrop-blur-sm"
         onclick="if(event.target===this) closeLogout()">
        <div class="rise w-full max-w-sm bg-white rounded-3xl p-7 text-center shadow-2xl">
            <div class="bob w-16 h-16 mx-auto rounded-2xl bg-[#FFF6D6] grid place-items-center text-4xl">👋</div>
            <h3 class="font-display font-extrabold text-2xl text-[#0b4a35] mt-4">Leaving already?</h3>
            <p class="text-sm text-gray-500 mt-1">You will be logged out of the admin panel.</p>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeLogout()" class="flex-1 py-3 rounded-xl bg-[#eef5ea] text-[#0b4a35] font-semibold hover:bg-[#dfeadb] transition">Stay</button>
                <form method="POST" action="{{ route($logoutRoute) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition active:scale-95">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Logout modal
        const modal = document.getElementById('logoutModal');
        function openLogout()  { modal.classList.remove('hidden'); modal.classList.add('flex'); }
        function closeLogout() { modal.classList.add('hidden'); modal.classList.remove('flex'); }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLogout(); });

        // Greeting + live clock
        function tick() {
            const d = new Date(), h = d.getHours();
            document.getElementById('greet').textContent = h < 12 ? 'Good morning' : h < 17 ? 'Good afternoon' : 'Good evening';
            document.getElementById('clock').textContent = d.toLocaleTimeString('en-IN', {hour:'2-digit', minute:'2-digit', second:'2-digit'});
            document.getElementById('date').textContent = d.toLocaleDateString('en-IN', {weekday:'short', day:'numeric', month:'short'});
        }
        tick(); setInterval(tick, 1000);

        // Count-up on stats
        document.querySelectorAll('[data-count]').forEach(el => {
            const target = parseInt(el.dataset.count, 10) || 0;
            if (!target) return;
            let n = 0; const step = Math.max(1, Math.ceil(target / 30));
            el.textContent = 0;
            const t = setInterval(() => { n = Math.min(target, n + step); el.textContent = n; if (n >= target) clearInterval(t); }, 30);
        });

        // Scroll reveal
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // Ripple on buttons
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

        // Refresh button
        document.getElementById('refreshBtn').addEventListener('click', () => {
            const icon = document.getElementById('refreshIcon');
            icon.classList.add('spin-once');
            setTimeout(() => location.reload(), 500);
        });

        // Filter (stat cards) + search
        const stats = document.querySelectorAll('.stat');
        const cards = document.querySelectorAll('[data-status]');
        const search = document.getElementById('search');
        const countEl = document.getElementById('visibleCount');
        const emptyEl = document.getElementById('filterEmpty');
        let filter = 'all';

        function apply() {
            const q = (search?.value || '').trim().toLowerCase();
            let shown = 0;
            cards.forEach(c => {
                const show = (filter === 'all' || c.dataset.status === filter) && c.dataset.search.includes(q);
                c.classList.toggle('hidden', !show);
                if (show) { shown++; c.classList.add('in'); }
            });
            if (countEl) countEl.textContent = shown;
            if (emptyEl) emptyEl.classList.toggle('hidden', shown !== 0);
        }
        stats.forEach(s => s.addEventListener('click', () => {
            stats.forEach(x => x.classList.remove('active'));
            s.classList.add('active');
            filter = s.dataset.filter;
            apply();
        }));
        search?.addEventListener('input', apply);

        // Toast
        function closeToast(id) {
            const toast = document.getElementById(id);
            if (!toast) return;
            toast.classList.add('toast-hide');
            setTimeout(() => toast.remove(), 400);
        }
        setTimeout(() => { closeToast('successToast'); closeToast('errorToast'); }, 4000);
    </script>

</x-app-layout>
