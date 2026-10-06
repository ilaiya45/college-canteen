<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify KOT {{ $order->kot_number }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --pine: #0e2f2c;
            --pine-2: #164540;
            --paper: #ffffff;
            --ink: #16211e;
            --muted: #6b7a74;
            --line: #d9dfdb;
        }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background: var(--pine);
            color: var(--ink);
        }

        .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        /* Ticket zig-zag edges */
        .zig {
            height: 10px;
            background:
                linear-gradient(135deg, var(--paper) 5px, transparent 0) 0 0 / 14px 10px repeat-x,
                linear-gradient(225deg, var(--paper) 5px, transparent 0) 0 0 / 14px 10px repeat-x;
        }
        .zig-top { transform: rotate(180deg); }

        .ticket-shadow { filter: drop-shadow(0 24px 32px rgba(0, 0, 0, .35)); }

        /* The one orchestrated moment: the ticket prints out */
        @keyframes print {
            from { transform: translateY(-28px); clip-path: inset(0 0 100% 0); opacity: .5; }
            to   { transform: translateY(0);     clip-path: inset(0 0 0 0);    opacity: 1; }
        }
        .ticket { animation: print .9s cubic-bezier(.2, .7, .2, 1) both; }

        @keyframes fill { from { transform: scaleX(0); } to { transform: scaleX(1); } }
        .fill { transform-origin: left; animation: fill .5s ease-out both; }

        /* Attention pulse only on the current step / ready badge */
        @keyframes ping-soft {
            0%   { transform: scale(1);   opacity: .55; }
            100% { transform: scale(2.4); opacity: 0; }
        }
        .ping { animation: ping-soft 1.6s ease-out infinite; }

        /* Stamp: answers the person's click */
        .stamp {
            opacity: 0;
            transform: rotate(-12deg) scale(1);
            pointer-events: none;
        }
        .stamp-show { opacity: 1; }
        .stamp-anim { animation: stamp .45s cubic-bezier(.2, 1.3, .4, 1) both; }
        @keyframes stamp {
            from { opacity: 0; transform: rotate(-12deg) scale(2.2); }
            to   { opacity: 1; transform: rotate(-12deg) scale(1); }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation: none !important; transition: none !important; }
        }
    </style>
</head>

@php
    $statusMap = [
        'pending'   => ['label' => 'Pending',         'pill' => 'bg-amber-100 text-amber-800',  'dot' => 'bg-amber-500'],
        'preparing' => ['label' => 'Preparing',       'pill' => 'bg-sky-100 text-sky-800',      'dot' => 'bg-sky-500'],
        'ready'     => ['label' => 'Ready for pickup','pill' => 'bg-emerald-100 text-emerald-800','dot' => 'bg-emerald-500'],
        'completed' => ['label' => 'Handed over',     'pill' => 'bg-slate-200 text-slate-700',  'dot' => 'bg-slate-500'],
    ];
    $badge = $statusMap[$order->status] ?? $statusMap['pending'];

    $steps = ['pending' => 'Pending', 'preparing' => 'Preparing', 'ready' => 'Ready', 'completed' => 'Done'];
    $stepKeys = array_keys($steps);
    $current = array_search($order->status, $stepKeys);
    $current = $current === false ? 0 : $current;
@endphp

<body class="min-h-screen antialiased">

    <div class="max-w-md mx-auto px-4 pt-6 pb-12">

        {{-- Top bar --}}
        <div class="flex items-center justify-between mb-8 text-white">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-white/80 hover:text-white transition-colors
                      focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 rounded-lg px-1 py-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Dashboard
            </a>
            <p class="text-sm text-white/60">Counter check</p>
        </div>

        <div class="mb-6 text-white">
            <h1 class="text-2xl font-bold tracking-tight">Verify order</h1>
            <p class="text-white/70 text-sm mt-1">Match the KOT number with the student before handing over the food.</p>
        </div>

        {{-- Ticket --}}
        <div class="ticket-shadow">
            <div class="ticket relative">

                <div class="zig zig-top"></div>

                <div class="relative bg-[var(--paper)] px-6 pt-5 pb-6">

                    {{-- Stamp --}}
                    <div id="stamp"
                         class="stamp {{ $order->status === 'completed' ? 'stamp-show' : '' }}
                                absolute right-4 top-24 z-10 mono font-semibold text-lg tracking-widest
                                text-emerald-700 border-[3px] border-emerald-700 rounded-md px-3 py-1 bg-white/80">
                        HANDED OVER
                    </div>

                    {{-- KOT header --}}
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-[var(--muted)]">KOT number</p>
                            <p class="mono text-4xl font-semibold tracking-tight leading-tight">{{ $order->kot_number }}</p>
                        </div>

                        <span class="relative inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium {{ $badge['pill'] }}">
                            <span class="relative flex w-2 h-2">
                                @if($order->status === 'ready')
                                    <span class="ping absolute inset-0 rounded-full {{ $badge['dot'] }}"></span>
                                @endif
                                <span class="relative w-2 h-2 rounded-full {{ $badge['dot'] }}"></span>
                            </span>
                            {{ $badge['label'] }}
                        </span>
                    </div>

                    <div class="mt-4 flex items-center gap-2 text-[var(--muted)]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Student</span>
                        <span class="font-bold text-[var(--ink)]">{{ $order->user->name }}</span>
                    </div>

                    <div class="border-t border-dashed border-[var(--line)] my-5"></div>

                    {{-- Progress --}}
                    <div class="flex items-center" role="list" aria-label="Order progress">
                        @foreach($steps as $key => $label)
                            @php $i = $loop->index; @endphp

                            <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}" role="listitem">
                                <div class="relative flex flex-col items-center">
                                    <div @class([
                                        'relative w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0',
                                        'bg-[var(--pine)] text-white' => $i <= $current,
                                        'bg-gray-100 text-gray-300 border border-[var(--line)]' => $i > $current,
                                    ])>
                                        @if($i < $current)
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @elseif($i === $current)
                                            @if($order->status !== 'completed')
                                                <span class="ping absolute inset-0 rounded-full bg-[var(--pine)]"></span>
                                            @endif
                                            <span class="relative w-2 h-2 rounded-full bg-white"></span>
                                        @endif
                                    </div>
                                    <span @class([
                                        'absolute top-9 text-xs whitespace-nowrap',
                                        'font-bold text-[var(--ink)]' => $i === $current,
                                        'text-[var(--muted)]' => $i !== $current,
                                    ])>{{ $label }}</span>
                                </div>

                                @if(!$loop->last)
                                    <div class="flex-1 h-0.5 mx-1.5 rounded bg-gray-200 overflow-hidden">
                                        @if($i < $current)
                                            <div class="fill h-full bg-[var(--pine)]" style="animation-delay: {{ .5 + $i * .2 }}s"></div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="h-7"></div>

                    <div class="border-t border-dashed border-[var(--line)] my-5"></div>

                    {{-- Items --}}
                    <p class="text-sm text-[var(--muted)] mb-3">Ordered items</p>

                    <ul class="space-y-3">
                        @foreach($order->items as $item)
                            <li class="flex items-baseline gap-2">
                                <span class="mono text-sm font-semibold w-8 flex-shrink-0">{{ $item->quantity }}×</span>
                                <span class="font-medium">{{ $item->snack->name }}</span>
                                <span class="flex-1 border-b border-dotted border-[var(--line)] translate-y-[-3px]"></span>
                                <span class="mono text-sm">₹{{ number_format($item->subtotal, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="border-t-2 border-[var(--ink)] mt-5 pt-4 flex items-baseline justify-between">
                        <span class="font-bold">Total</span>
                        <span class="mono text-2xl font-semibold">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>

                    {{-- Handover --}}
                    <div class="mt-6">

                        @if($order->status === 'ready')

                            <form id="handoverForm" method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">

                                <p class="text-sm text-emerald-800 bg-emerald-50 rounded-xl px-4 py-3 mb-3">
                                    Order is ready. Check the KOT number, then hand over the food.
                                </p>

                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 bg-[var(--pine)] text-white
                                               px-6 py-4 rounded-xl font-bold hover:bg-[var(--pine-2)] active:scale-[.98]
                                               transition focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Verify and hand over
                                </button>
                            </form>

                        @elseif($order->status === 'completed')

                            <div class="text-center rounded-xl bg-gray-50 border border-[var(--line)] px-4 py-4">
                                <p class="font-bold">Already handed over</p>
                                <p class="text-sm text-[var(--muted)] mt-0.5">This order is closed. No action needed.</p>
                            </div>

                        @else

                            <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-4 flex gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-bold text-amber-900">Not ready yet</p>
                                    <p class="text-sm text-amber-800 mt-0.5">Mark the order as Ready for pickup before handing it over.</p>
                                </div>
                            </div>

                        @endif

                    </div>
                </div>

                <div class="zig"></div>
            </div>
        </div>

    </div>

    <script>
        // Stamp animation plays first, then the form submits
        (function () {
            var form = document.getElementById('handoverForm');
            if (!form) return;

            form.addEventListener('submit', function (e) {
                if (form.dataset.sent) return;
                e.preventDefault();
                form.dataset.sent = '1';

                var stamp = document.getElementById('stamp');
                stamp.classList.add('stamp-show', 'stamp-anim');

                var btn = form.querySelector('button');
                btn.disabled = true;
                btn.classList.add('opacity-70');

                var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                setTimeout(function () { form.submit(); }, reduce ? 0 : 750);
            });
        })();
    </script>

</body>

</html>
