<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background:#FBB017">
                🍽️
            </div>
            <h2 class="font-bold text-xl leading-tight" style="color:#0F3D2E">
                Order Details
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap');

        [x-cloak] { display:none !important; }

        .od { --green:#0F3D2E; --yellow:#FBB017; --leaf:#7BA23F; --cream:#FFFBF0; font-family:'Nunito',system-ui,sans-serif; }
        .od .f-display { font-family:'Baloo 2','Nunito',sans-serif; }
        .od .f-script  { font-family:'Caveat','Nunito',cursive; }

        /* the one orchestrated moment: the token drops in, then the rest follows */
        .od .drop { opacity:0; transform:translateY(-40px) rotate(-3deg); animation:odDrop .8s cubic-bezier(.2,.9,.3,1.25) forwards; }
        @keyframes odDrop { to { opacity:1; transform:none; } }
        .od .rise { opacity:0; transform:translateY(20px); animation:odRise .6s ease forwards; }
        .od .r1{animation-delay:.35s} .od .r2{animation-delay:.5s} .od .r3{animation-delay:.65s}
        @keyframes odRise { to { opacity:1; transform:none; } }

        .od .leaf { position:absolute; animation:odFloat 7s ease-in-out infinite; }
        .od .leaf.l2 { animation-duration:9s; animation-delay:-3s; }
        @keyframes odFloat { 0%,100%{transform:translateY(0) rotate(-8deg)} 50%{transform:translateY(-12px) rotate(8deg)} }

        /* payment verified tick draws itself */
        .od .tick { stroke-dasharray:30; stroke-dashoffset:30; animation:odTick .6s .9s ease forwards; }
        @keyframes odTick { to { stroke-dashoffset:0; } }

        .od .hourglass { display:inline-block; animation:odFlip 2.4s ease-in-out infinite; }
        @keyframes odFlip { 0%,60%{transform:rotate(0)} 80%,100%{transform:rotate(180deg)} }

        .od .fill { width:0; animation:odFill 1s .8s cubic-bezier(.3,.8,.3,1) forwards; }
        @keyframes odFill { to { width:var(--w); } }

        .od .now { animation:odPulse 1.8s ease-in-out infinite; }
        @keyframes odPulse { 0%{box-shadow:0 0 0 0 rgba(251,176,23,.7)} 70%{box-shadow:0 0 0 12px rgba(251,176,23,0)} 100%{box-shadow:0 0 0 0 rgba(251,176,23,0)} }

        .od .ring { display:inline-block; transform-origin:50% 10%; animation:odRing 2.4s ease-in-out infinite; }
        @keyframes odRing { 0%,60%,100%{transform:rotate(0)} 10%{transform:rotate(16deg)} 20%{transform:rotate(-14deg)} 30%{transform:rotate(10deg)} 40%{transform:rotate(-8deg)} 50%{transform:rotate(4deg)} }

        /* ticket notches */
        .od .notch { position:relative; }
        .od .notch::before, .od .notch::after { content:''; position:absolute; top:50%; width:22px; height:22px; margin-top:-11px; border-radius:50%; background:var(--cream); }
        .od .notch::before { left:-11px; } .od .notch::after { right:-11px; }

        .od .item { transition:background .2s ease; }
        .od .item:hover { background:#fffaf0; }
        .od :focus-visible { outline:3px solid var(--yellow); outline-offset:3px; }

        @media (prefers-reduced-motion: reduce) {
            .od *, .od *::before, .od *::after { animation:none !important; transition:none !important; }
            .od .drop, .od .rise { opacity:1; transform:none; }
            .od .tick { stroke-dashoffset:0; }
            .od .fill { width:var(--w); }
        }
    </style>

    @php
        $pay = $order->payment_status;
        $verified = in_array($pay, ['confirmed', 'paid'], true);

        $steps = ['pending', 'preparing', 'ready', 'completed'];
        $stepLabels = ['Order placed', 'Preparing', 'Ready', 'Completed'];
        $stepEmoji = ['🧾', '👨‍🍳', '🔔', '✅'];
        $currentIndex = array_search($order->status, $steps);
        if ($currentIndex === false) { $currentIndex = -1; }
        $isReady = $order->status === 'ready';
        $statusLabel = ucfirst(str_replace('_', ' ', $order->status));
    @endphp


    <div class="od min-h-screen pb-16" style="background:var(--cream)">

        {{-- ================= BANNER WITH TOKEN ================= --}}
        <section class="relative overflow-hidden" style="background:var(--green)">

            <div class="absolute inset-0 opacity-10"
                 style="background-image:radial-gradient(circle at 2px 2px,#fff 1px,transparent 0);background-size:24px 24px"></div>

            <svg class="leaf" style="left:3%;top:14px" width="40" height="52" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#7BA23F"/>
            </svg>
            <svg class="leaf l2 hidden sm:block" style="right:8%;top:20px" width="34" height="44" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#FBB017"/>
            </svg>

            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-4 text-center">

                <p class="rise r1 f-script text-2xl" style="color:var(--yellow)">Show this token at the counter</p>

                <div class="drop inline-block mt-2 rounded-3xl px-5 sm:px-10 py-4 shadow-xl max-w-full"
                     style="background:var(--yellow); color:var(--green)">
                    <p class="text-sm font-bold leading-none">Kitchen order token</p>
                    <h1 class="f-display text-3xl sm:text-5xl md:text-6xl font-extrabold leading-tight break-all">
                        #{{ $order->kot_number }}
                    </h1>
                </div>
            </div>

            <svg class="block w-full h-8 sm:h-10 mt-2" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 40V18C240 -6 480 -6 720 14s480 20 720 -4v30z" fill="#FFFBF0"/>
            </svg>
        </section>


        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success --}}
            @if(session('success'))
                <div class="mb-4 flex items-center gap-3 rounded-2xl p-4" role="status"
                     style="background:#e4f0cf; border:2px solid #c8e1a3">
                    <span class="text-2xl" aria-hidden="true">✅</span>
                    <div>
                        <p class="font-extrabold" style="color:var(--green)">Done!</p>
                        <p class="text-sm" style="color:#2b5a49">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error --}}
            @if(session('error'))
                <div class="mb-4 flex items-center gap-3 rounded-2xl p-4" role="alert"
                     style="background:#fde2df; border:2px solid #f5b5ae">
                    <span class="text-2xl" aria-hidden="true">❌</span>
                    <div>
                        <p class="font-extrabold" style="color:#9b1c1c">Payment / order error</p>
                        <p class="text-sm" style="color:#9b1c1c">{{ session('error') }}</p>
                    </div>
                </div>
            @endif


            {{-- ================= PAYMENT STATUS ================= --}}
            <div class="rise r2 rounded-3xl p-4 sm:p-5 flex flex-col sm:flex-row items-start gap-4"
                 style="{{ $verified ? 'background:#e4f0cf;border:2px solid #c8e1a3'
                        : ($pay === 'submitted' ? 'background:#FDE9A8;border:2px solid #f5d271'
                        : ($pay === 'rejected' ? 'background:#fde2df;border:2px solid #f5b5ae'
                        : 'background:#f3ecd8;border:2px solid #e6d9b3')) }}">

                <div class="shrink-0 w-12 h-12 rounded-full flex items-center justify-center text-2xl"
                     style="background:{{ $verified ? '#0F3D2E' : '#fff' }}">
                    @if($verified)
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#FBB017" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <path class="tick" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif($pay === 'submitted')
                        <span class="hourglass" aria-hidden="true">⏳</span>
                    @elseif($pay === 'rejected')
                        <span aria-hidden="true">✕</span>
                    @else
                        <span aria-hidden="true">💳</span>
                    @endif
                </div>

                <div class="flex-1">
                    @if($verified)
                        <h2 class="f-display text-xl font-extrabold" style="color:var(--green)">Payment verified</h2>
                        <p class="text-sm mt-0.5" style="color:#2b5a49">The canteen confirmed your payment. Your order is with the kitchen.</p>
                    @elseif($pay === 'submitted')
                        <h2 class="f-display text-xl font-extrabold" style="color:#5c4400">Verification pending</h2>
                        <p class="text-sm mt-0.5" style="color:#5c4400">We got your transaction ID. The kitchen starts once the canteen verifies it.</p>
                    @elseif($pay === 'rejected')
                        <h2 class="f-display text-xl font-extrabold" style="color:#9b1c1c">Payment rejected</h2>
                        <p class="text-sm mt-0.5" style="color:#9b1c1c">The canteen could not match your transaction ID. Check the amount and ID, or place the order again.</p>
                        <a href="{{ route('food.index') }}" class="inline-flex mt-3 font-bold text-sm px-4 py-2 rounded-full"
                           style="background:#9b1c1c; color:#fff">Order again</a>
                    @else
                        <h2 class="f-display text-xl font-extrabold" style="color:var(--green)">Payment pending</h2>
                        <p class="text-sm mt-0.5 text-gray-600">Your order starts after payment is verified.</p>
                    @endif
                </div>
            </div>


            {{-- ================= ORDER PROGRESS (only after payment is verified) ================= --}}
            @if($verified)
                <div class="rise r3 mt-6 bg-white rounded-3xl p-6" style="border:2px solid {{ $isReady ? '#FBB017' : '#f3e6c4' }}; {{ $isReady ? 'box-shadow:0 0 0 4px rgba(251,176,23,.18)' : '' }}">

                    <div class="flex items-center justify-between gap-3">
                        <h2 class="f-display text-2xl font-extrabold" style="color:var(--green)">Order progress</h2>
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full font-bold text-sm"
                              style="{{ $isReady ? 'background:#0F3D2E;color:#FBB017' : 'background:#FDE9A8;color:#5c4400' }}">
                            @if($isReady)<span class="ring">🔔</span>@endif
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="mt-8" role="img" aria-label="Order status: {{ $statusLabel }}">
                        <div class="relative grid grid-cols-4 gap-1 sm:gap-2 text-center overflow-x-auto">

                            <div class="absolute top-5 left-[12.5%] right-[12.5%] h-1.5 rounded-full" style="background:#f3e6c4">
                                <div class="fill h-full rounded-full"
                                     style="--w:{{ $currentIndex >= 0 ? ($currentIndex / 3) * 100 : 0 }}%; background:linear-gradient(90deg,#7BA23F,#0F3D2E)"></div>
                            </div>

                            @foreach($stepLabels as $i => $label)
                                @php
                                    $done = $currentIndex > $i;
                                    $current = $currentIndex === $i && $order->status !== 'completed';
                                    $reached = $currentIndex >= $i;
                                @endphp
                                <div class="relative z-10">
                                    <div class="mx-auto w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-sm sm:text-base font-bold {{ $current ? 'now' : '' }}"
                                         style="{{ $reached
                                             ? ($current ? 'background:#FBB017;color:#0F3D2E' : 'background:#0F3D2E;color:#fff')
                                             : 'background:#f3e6c4;color:#b7a67a' }}">
                                        {{ $done || ($currentIndex === $i && $order->status === 'completed') ? '✓' : $stepEmoji[$i] }}
                                    </div>
                                    <p class="text-[10px] sm:text-xs md:text-sm mt-2 font-semibold leading-tight" style="color:{{ $reached ? '#0F3D2E' : '#b7a67a' }}">{{ $label }}</p>
                                </div>
                            @endforeach

                        </div>

                        @if($isReady)
                            <p class="f-script text-2xl text-center mt-5" style="color:var(--green)">
                                Your food is hot and ready. Show your token at the counter!
                            </p>
                        @endif
                    </div>
                </div>
            @endif


            {{-- ================= RECEIPT ================= --}}
            <div class="mt-6 bg-white rounded-3xl overflow-hidden" style="border:2px solid #f3e6c4">

                <div class="px-6 py-5 flex flex-wrap items-center justify-between gap-3" style="border-bottom:2px dashed #f3e6c4">
                    <h2 class="f-display text-2xl font-extrabold" style="color:var(--green)">Order items</h2>
                    <p class="text-sm text-gray-500">Order #{{ $order->id }}</p>
                </div>

                <div>
                    @foreach($order->items as $item)
                        <div class="item p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4"
                             style="{{ !$loop->last ? 'border-bottom:1px solid #f7efd6' : '' }}">

                            <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl overflow-hidden flex items-center justify-center shrink-0"
                                     style="background:linear-gradient(135deg,#FDE9A8,#FBB017)">
                                    @if($item->snack && $item->snack->image)
                                        <img src="{{ asset($item->snack->image) }}" alt="{{ $item->snack->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl" aria-hidden="true">🍽️</span>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <p class="f-display text-lg font-extrabold truncate" style="color:var(--green)">
                                        {{ $item->snack->name ?? 'Food item' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        ₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                    </p>
                                </div>
                            </div>

                            <p class="f-display text-lg sm:text-xl font-extrabold self-end sm:self-auto" style="color:var(--green)">
                                ₹{{ number_format($item->subtotal, 2) }}
                            </p>

                        </div>
                    @endforeach
                </div>

                <div class="px-4 sm:px-6 py-5 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2" style="background:#fff7dd; border-top:2px dashed #f3e6c4">
                    <span class="font-bold" style="color:var(--green)">Total amount</span>
                    <span class="f-display text-2xl sm:text-3xl font-extrabold" style="color:var(--green)">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>

            </div>


            {{-- ================= BUTTONS ================= --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-3">

                <a href="{{ route('orders.index') }}"
                   class="flex-1 inline-flex items-center justify-center text-white py-3 rounded-full font-bold
                          hover:scale-[1.03] active:scale-[.97] transition"
                   style="background:var(--green)">
                    View my orders
                </a>

                <a href="{{ route('students.dashboard') }}"
                   class="flex-1 inline-flex items-center justify-center py-3 rounded-full font-bold hover:bg-white transition"
                   style="border:2px solid var(--green); color:var(--green)">
                    Back to dashboard
                </a>

            </div>

        </div>

    </div>

</x-app-layout>
