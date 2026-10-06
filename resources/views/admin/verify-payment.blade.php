<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#0e2f2c] text-white flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800">Verify payment</h2>
        </div>
    </x-slot>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        .pay-scope {
            --pine: #0e2f2c;
            --pine-2: #164540;
            --paper: #ffffff;
            --ink: #16211e;
            --muted: #6b7a74;
            --line: #d9dfdb;
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            color: var(--ink);
            background: var(--pine);
        }
        .pay-scope .mono { font-family: 'IBM Plex Mono', ui-monospace, monospace; }

        .pay-scope .zig {
            height: 10px;
            background:
                linear-gradient(135deg, var(--paper) 5px, transparent 0) 0 0 / 14px 10px repeat-x,
                linear-gradient(225deg, var(--paper) 5px, transparent 0) 0 0 / 14px 10px repeat-x;
        }
        .pay-scope .zig-top { transform: rotate(180deg); }
        .pay-scope .ticket-shadow { filter: drop-shadow(0 24px 32px rgba(0, 0, 0, .35)); }

        @keyframes pay-print {
            from { transform: translateY(-28px); clip-path: inset(0 0 100% 0); opacity: .5; }
            to   { transform: translateY(0);     clip-path: inset(0 0 0 0);    opacity: 1; }
        }
        .pay-scope .ticket { animation: pay-print .9s cubic-bezier(.2, .7, .2, 1) both; }

        @keyframes pay-stamp {
            from { opacity: 0; transform: rotate(-12deg) scale(2.2); }
            to   { opacity: 1; transform: rotate(-12deg) scale(1); }
        }
        .pay-scope .stamp { opacity: 0; transform: rotate(-12deg); pointer-events: none; }
        .pay-scope .stamp-show { opacity: 1; }
        .pay-scope .stamp-anim { animation: pay-stamp .45s cubic-bezier(.2, 1.3, .4, 1) both; }

        @media (prefers-reduced-motion: reduce) {
            .pay-scope *, .pay-scope *::before, .pay-scope *::after { animation: none !important; transition: none !important; }
        }
    </style>

    @php
        $payMap = [
            'pending'   => ['pill' => 'bg-amber-100 text-amber-800',    'dot' => 'bg-amber-500'],
            'paid'      => ['pill' => 'bg-emerald-100 text-emerald-800', 'dot' => 'bg-emerald-500'],
            'confirmed' => ['pill' => 'bg-emerald-100 text-emerald-800', 'dot' => 'bg-emerald-500'],
            'rejected'  => ['pill' => 'bg-red-100 text-red-800',        'dot' => 'bg-red-500'],
        ];
        $pay = $payMap[strtolower($order->payment_status)] ?? $payMap['pending'];
    @endphp

    <div class="pay-scope min-h-screen py-8 px-4 antialiased">
        <div class="max-w-md mx-auto">

            <div class="mb-6 text-white">
                <h1 class="text-2xl font-bold tracking-tight">Payment verification</h1>
                <p class="text-white/70 text-sm mt-1">Match the UTR with your bank or UPI statement, then confirm or reject.</p>
            </div>

            <div class="ticket-shadow">
                <div class="ticket relative">

                    <div class="zig zig-top"></div>

                    <div class="relative bg-[var(--paper)] px-6 pt-5 pb-6">

                        {{-- Stamp (text and colour are set by JS) --}}
                        <div id="payStamp"
                             class="stamp absolute right-4 top-28 z-10 mono font-semibold text-lg tracking-widest
                                    border-[3px] rounded-md px-3 py-1 bg-white/80"></div>

                        {{-- Student --}}
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm text-[var(--muted)]">Student</p>
                                <p class="font-bold text-lg leading-tight truncate">{{ $order->user->name }}</p>
                                <p class="text-sm text-[var(--muted)] truncate">{{ $order->user->email }}</p>
                            </div>

                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-medium flex-shrink-0 {{ $pay['pill'] }}">
                                <span class="w-2 h-2 rounded-full {{ $pay['dot'] }}"></span>
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>

                        <div class="border-t border-dashed border-[var(--line)] my-5"></div>

                        {{-- KOT + Amount --}}
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-sm text-[var(--muted)]">KOT number</p>
                                <p class="mono text-2xl font-semibold tracking-tight">{{ $order->kot_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-[var(--muted)]">Amount to receive</p>
                                <p class="mono text-2xl font-semibold text-emerald-700">₹{{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>

                        {{-- UTR: the thing being checked, so it gets the most weight --}}
                        <div class="mt-5 rounded-xl border-2 border-[var(--ink)] px-4 py-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-[var(--muted)]">UTR / Transaction ID</p>
                                <button type="button" id="copyUtr"
                                        data-utr="{{ $order->payment_reference }}"
                                        class="text-sm font-medium text-[var(--pine)] hover:underline rounded
                                               focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-400">
                                    Copy
                                </button>
                            </div>
                            <p class="mono text-2xl font-semibold tracking-wide break-all mt-1">{{ $order->payment_reference }}</p>
                        </div>

                        <div class="border-t border-dashed border-[var(--line)] my-5"></div>

                        {{-- Items --}}
                        <p class="text-sm text-[var(--muted)] mb-3">Order items</p>

                        <ul class="space-y-3">
                            @foreach($order->items as $item)
                                <li class="flex items-baseline gap-2">
                                    <span class="mono text-sm font-semibold w-8 flex-shrink-0">{{ $item->quantity }}×</span>
                                    <span class="min-w-0">
                                        <span class="font-medium">{{ $item->snack->name }}</span>
                                        <span class="block text-xs text-[var(--muted)] mono">₹{{ number_format($item->price, 2) }} each</span>
                                    </span>
                                    <span class="flex-1 border-b border-dotted border-[var(--line)] translate-y-[-3px]"></span>
                                    <span class="mono text-sm">₹{{ number_format($item->subtotal, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-t-2 border-[var(--ink)] mt-5 pt-4 flex items-baseline justify-between">
                            <span class="font-bold">Total</span>
                            <span class="mono text-2xl font-semibold">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-6 grid grid-cols-2 gap-3">

                            <form action="{{ route('admin.orders.reject-payment', $order) }}" method="POST"
                                  class="payForm" data-stamp="REJECTED" data-color="red">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full px-4 py-3.5 rounded-xl font-bold text-red-700 border-2 border-red-200
                                               hover:bg-red-50 active:scale-[.98] transition
                                               focus:outline-none focus-visible:ring-4 focus-visible:ring-red-200">
                                    Reject
                                </button>
                            </form>

                            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST"
                                  class="payForm" data-stamp="PAID" data-color="green">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full px-4 py-3.5 rounded-xl font-bold text-white bg-[var(--pine)]
                                               hover:bg-[var(--pine-2)] active:scale-[.98] transition
                                               focus:outline-none focus-visible:ring-4 focus-visible:ring-emerald-300">
                                    Confirm payment
                                </button>
                            </form>

                        </div>

                        <p class="text-xs text-[var(--muted)] text-center mt-3">
                            Confirming sends the order to the kitchen. Rejecting cancels the payment.
                        </p>
                    </div>

                    <div class="zig"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        (function () {
            // Copy UTR
            var copyBtn = document.getElementById('copyUtr');
            if (copyBtn && navigator.clipboard) {
                copyBtn.addEventListener('click', function () {
                    navigator.clipboard.writeText(copyBtn.dataset.utr).then(function () {
                        copyBtn.textContent = 'Copied';
                        setTimeout(function () { copyBtn.textContent = 'Copy'; }, 1500);
                    });
                });
            }

            // Stamp, then submit
            var stamp = document.getElementById('payStamp');
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var colors = {
                green: ['text-emerald-700', 'border-emerald-700'],
                red:   ['text-red-700', 'border-red-700']
            };

            document.querySelectorAll('.payForm').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (document.body.dataset.paySent) { e.preventDefault(); return; }
                    if (form.dataset.ok) return;
                    e.preventDefault();
                    form.dataset.ok = '1';
                    document.body.dataset.paySent = '1';

                    stamp.textContent = form.dataset.stamp;
                    stamp.classList.add.apply(stamp.classList, colors[form.dataset.color]);
                    stamp.classList.add('stamp-show', 'stamp-anim');

                    document.querySelectorAll('.payForm button').forEach(function (b) {
                        b.disabled = true;
                        b.classList.add('opacity-60');
                    });

                    setTimeout(function () { form.submit(); }, reduce ? 0 : 750);
                });
            });
        })();
    </script>

</x-app-layout>
