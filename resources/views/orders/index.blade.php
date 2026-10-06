<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            --green: #0F3D2E;
            --yellow: #FBB017;
            --leaf: #7BA23F;
            --cream: #FFFBF0;

            font-family: 'Nunito', system-ui, sans-serif;
            background: var(--cream);
        }

        .f-display {
            font-family: 'Baloo 2', 'Nunito', sans-serif;
        }

        .f-script {
            font-family: 'Caveat', 'Nunito', cursive;
        }

        /* Header animation */
        .pop {
            opacity: 0;
            transform: translateY(20px) scale(.97);
            animation: pop .6s cubic-bezier(.2, .9, .3, 1.2) forwards;
        }

        .d1 {
            animation-delay: .05s
        }

        .d2 {
            animation-delay: .2s
        }

        .d3 {
            animation-delay: .35s
        }

        @keyframes pop {
            to {
                opacity: 1;
                transform: none;
            }
        }

        .leaf {
            position: absolute;
            animation: float 7s ease-in-out infinite;
        }

        .leaf.l2 {
            animation-duration: 9s;
            animation-delay: -3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(-8deg)
            }

            50% {
                transform: translateY(-12px) rotate(8deg)
            }
        }

        /* Progress */
        .fill {
            width: 0;
            animation: fill 1s .3s cubic-bezier(.3, .8, .3, 1) forwards;
        }

        @keyframes fill {
            to {
                width: var(--w);
            }
        }

        .now {
            animation: pulse 1.8s ease-in-out infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(251, 176, 23, .7)
            }

            70% {
                box-shadow: 0 0 0 12px rgba(251, 176, 23, 0)
            }

            100% {
                box-shadow: 0 0 0 0 rgba(251, 176, 23, 0)
            }
        }

        /* Bell */
        .ring {
            display: inline-block;
            transform-origin: 50% 10%;
            animation: ring 2.4s ease-in-out infinite;
        }

        @keyframes ring {

            0%,
            60%,
            100% {
                transform: rotate(0)
            }

            10% {
                transform: rotate(16deg)
            }

            20% {
                transform: rotate(-14deg)
            }

            30% {
                transform: rotate(10deg)
            }

            40% {
                transform: rotate(-8deg)
            }

            50% {
                transform: rotate(4deg)
            }
        }

        .plate {
            animation: wobble 2.6s ease-in-out infinite;
            transform-origin: 50% 90%;
        }

        @keyframes wobble {

            0%,
            100% {
                transform: rotate(-6deg)
            }

            50% {
                transform: rotate(6deg)
            }
        }

        .order {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .order:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 28px -18px rgba(15, 61, 46, .5);
        }

        @keyframes toast-progress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* Token notches */
        .token::before,
        .token::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 14px;
            height: 14px;
            margin-top: -7px;
            border-radius: 50%;
            background: var(--cream);
        }

        .token::before {
            left: -7px;
        }

        .token::after {
            right: -7px;
        }

        :focus-visible {
            outline: 3px solid var(--yellow);
            outline-offset: 3px;
        }

        /* ================= MOBILE RESPONSIVE ================= */

        @media (max-width: 640px) {

            body {
                overflow-x: hidden;
            }

            .order:hover {
                transform: none;
                box-shadow: none;
            }

            .token::before,
            .token::after {
                width: 12px;
                height: 12px;
                margin-top: -6px;
            }

            .token::before {
                left: -6px;
            }

            .token::after {
                right: -6px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }

            .pop {
                opacity: 1;
                transform: none;
            }

            .fill {
                width: var(--w);
            }
        }
    </style>
</head>

<body class="min-h-screen pb-16"
    x-data
    x-init="
        @if($orders->contains(fn ($o) => $o->status !== 'completed'))
            setInterval(() => {
                if (!document.hidden) location.reload();
            }, 30000);
        @endif
    ">

    {{-- ================= HEADER ================= --}}
    <header class="relative overflow-hidden" style="background:var(--green)">

        <div class="absolute inset-0 opacity-10"
            style="background-image:radial-gradient(circle at 2px 2px,#fff 1px,transparent 0);background-size:24px 24px">
        </div>

        <svg class="leaf" style="left:3%;top:14px" width="40" height="52"
            viewBox="0 0 46 60" aria-hidden="true">
            <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z"
                fill="#7BA23F" />
        </svg>

        <svg class="leaf l2 hidden sm:block" style="right:8%;top:20px"
            width="34" height="44" viewBox="0 0 46 60" aria-hidden="true">
            <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z"
                fill="#FBB017" />
        </svg>

        {{-- Header container --}}
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 pt-6 sm:pt-10 pb-5
                    flex flex-col md:flex-row
                    justify-between md:items-center gap-5">

            {{-- Title --}}
            <div class="flex items-center gap-3 sm:gap-4 min-w-0">

                <div class="pop d1
                            w-12 h-12 sm:w-14 sm:h-14
                            shrink-0 rounded-full
                            flex items-center justify-center
                            text-xl sm:text-2xl shadow-lg"
                    style="background:var(--yellow)">
                    🍽️
                </div>

                <div class="min-w-0">

                    <h1 class="pop d2 f-display
                               text-3xl sm:text-5xl
                               font-extrabold text-white
                               leading-tight">
                        My orders
                    </h1>

                    <p class="pop d3 f-script
                              text-xl sm:text-2xl"
                        style="color:var(--yellow)">
                        Good Food • Great Mood
                    </p>

                </div>
            </div>

            {{-- Dashboard --}}
            <a href="{{ route('students.dashboard') }}"
                class="pop d3 self-stretch sm:self-start md:self-auto
                       inline-flex items-center justify-center
                       gap-2 px-5 py-2.5
                       rounded-full font-semibold text-white
                       bg-white/10 hover:bg-white/20
                       border border-white/25 transition">

                <svg class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />

                </svg>

                Dashboard
            </a>

        </div>

        <svg class="block w-full h-7 sm:h-10 mt-2"
            viewBox="0 0 1440 40"
            preserveAspectRatio="none"
            aria-hidden="true">

            <path d="M0 40V18C240 -6 480 -6 720 14s480 20 720 -4v30z"
                fill="#FFFBF0" />

        </svg>

    </header>


    <main class="max-w-6xl mx-auto px-3 sm:px-6">

        {{-- ================= SUCCESS TOAST ================= --}}
        @if(session('success'))

            <div x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-300 transition"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                x-init="setTimeout(() => show = false, 4000)"
                role="status"
                class="fixed top-4 left-3 right-3
                       sm:left-auto sm:right-6
                       z-50 sm:w-[calc(100%-2rem)]
                       max-w-sm">

                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden"
                    style="border:2px solid #c8e1a3">

                    <div class="flex items-start gap-3 sm:gap-4 p-4">

                        <div class="shrink-0 w-10 h-10 sm:w-11 sm:h-11
                                    rounded-full flex items-center justify-center"
                            style="background:#e4f0cf">

                            <svg class="w-5 h-5 sm:w-6 sm:h-6"
                                style="color:var(--leaf)"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                        <div class="flex-1 min-w-0">

                            <h3 class="f-display font-extrabold text-lg"
                                style="color:var(--green)">
                                Done!
                            </h3>

                            <p class="text-sm text-gray-600 break-words">
                                {{ session('success') }}
                            </p>

                        </div>

                        <button type="button"
                            @click="show = false"
                            aria-label="Close"
                            class="text-gray-400 hover:text-gray-600 transition shrink-0">

                            <svg class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />

                            </svg>

                        </button>

                    </div>

                    <div class="h-1.5" style="background:#e4f0cf">

                        <div class="h-full"
                            style="background:var(--yellow); animation:toast-progress 4s linear forwards;">
                        </div>

                    </div>

                </div>

            </div>

        @endif


        {{-- ================= ORDERS ================= --}}
        <div class="space-y-5 sm:space-y-6 mt-2">

            @forelse($orders as $order)

                @php

                    $statusMap = [
                        'pending' => [
                            'label' => 'Pending',
                            'badge' => 'background:#FDE9A8;color:#5c4400',
                            'emoji' => '🕐'
                        ],

                        'preparing' => [
                            'label' => 'Preparing',
                            'badge' => 'background:#BFE3F9;color:#0b4a6e',
                            'emoji' => '👨‍🍳'
                        ],

                        'ready' => [
                            'label' => 'Ready for pickup',
                            'badge' => 'background:#0F3D2E;color:#FBB017',
                            'emoji' => '🔔'
                        ],

                        'completed' => [
                            'label' => 'Completed',
                            'badge' => 'background:#e4f0cf;color:#2b5a49',
                            'emoji' => '✅'
                        ],
                    ];

                    $steps = [
                        'pending',
                        'preparing',
                        'ready',
                        'completed'
                    ];

                    $stepLabels = [
                        'Order placed',
                        'Preparing',
                        'Ready',
                        'Completed'
                    ];

                    $stepEmoji = [
                        '🧾',
                        '👨‍🍳',
                        '🔔',
                        '✅'
                    ];

                    $currentIndex = array_search(
                        $order->status,
                        $steps
                    );

                    if ($currentIndex === false) {
                        $currentIndex = -1;
                    }

                    $isReady = $order->status === 'ready';

                    $s = $statusMap[$order->status] ?? [
                        'label' => ucfirst($order->status),
                        'badge' => 'background:#eee;color:#333',
                        'emoji' => ''
                    ];

                @endphp


                {{-- ================= ORDER CARD ================= --}}
                <article class="order relative bg-white rounded-2xl sm:rounded-3xl
                                p-4 sm:p-6"
                    style="border:2px solid {{ $isReady ? '#FBB017' : '#f3e6c4' }};
                           {{ $isReady ? 'box-shadow:0 0 0 4px rgba(251,176,23,.18)' : '' }}">


                    {{-- ================= ORDER HEADER ================= --}}
                    <div class="flex flex-col md:flex-row
                                md:justify-between md:items-center
                                gap-4">


                        {{-- Token + Date --}}
                        <div class="flex flex-col xs:flex-row
                                    sm:flex-row
                                    items-start sm:items-center
                                    gap-3 sm:gap-4">

                            {{-- KOT --}}
                            <div class="token relative shrink-0
                                        rounded-2xl
                                        px-4 sm:px-5
                                        py-2 text-center
                                        max-w-full"
                                style="background:var(--yellow); color:var(--green)">

                                <p class="text-xs font-bold leading-none">
                                    Token
                                </p>

                                <p class="f-display
                                          text-xl sm:text-2xl
                                          font-extrabold
                                          leading-tight
                                          break-all">
                                    #{{ $order->kot_number }}
                                </p>

                            </div>


                            {{-- Date --}}
                            <p class="text-xs sm:text-sm text-gray-500">

                                Ordered on<br>

                                <span class="font-semibold text-gray-700">
                                    {{ $order->created_at->format('d-m-Y h:i A') }}
                                </span>

                            </p>

                        </div>


                        {{-- Status --}}
                        <span class="self-start md:self-auto
                                     inline-flex items-center
                                     gap-2 px-3 sm:px-4 py-2
                                     rounded-full
                                     font-bold text-xs sm:text-sm
                                     max-w-full"
                            style="{{ $s['badge'] }}">

                            <span class="{{ $isReady ? 'ring' : '' }}">
                                {{ $s['emoji'] }}
                            </span>

                            <span class="truncate">
                                {{ $s['label'] }}
                            </span>

                        </span>

                    </div>


                    {{-- ================= PROGRESS ================= --}}
                    <div class="mt-7 sm:mt-8"
                        role="img"
                        aria-label="Order status: {{ $s['label'] }}">

                        <div class="relative
                                    grid grid-cols-4
                                    gap-1 sm:gap-2
                                    text-center
                                    min-w-0">


                            {{-- Progress line --}}
                            <div class="absolute
                                        top-4 sm:top-5
                                        left-[12.5%]
                                        right-[12.5%]
                                        h-1 sm:h-1.5
                                        rounded-full"
                                style="background:#f3e6c4">

                                <div class="fill h-full rounded-full"
                                    style="--w:{{ $currentIndex >= 0 ? ($currentIndex / 3) * 100 : 0 }}%;
                                           background:linear-gradient(90deg,#7BA23F,#0F3D2E)">
                                </div>

                            </div>


                            @foreach($stepLabels as $i => $label)

                                @php

                                    $done = $currentIndex > $i;

                                    $current = $currentIndex === $i
                                        && $order->status !== 'completed';

                                    $reached = $currentIndex >= $i;

                                @endphp


                                <div class="relative z-10 min-w-0">

                                    {{-- Circle --}}
                                    <div class="mx-auto
                                                w-8 h-8
                                                sm:w-10 sm:h-10
                                                rounded-full
                                                flex items-center justify-center
                                                text-sm sm:text-base
                                                font-bold transition
                                                {{ $current ? 'now' : '' }}"
                                        style="{{ $reached
                                            ? ($current
                                                ? 'background:#FBB017;color:#0F3D2E'
                                                : 'background:#0F3D2E;color:#fff')
                                            : 'background:#f3e6c4;color:#b7a67a' }}">

                                        {{ $done || ($currentIndex === $i && $order->status === 'completed')
                                            ? '✓'
                                            : $stepEmoji[$i] }}

                                    </div>


                                    {{-- Label --}}
                                    <p class="text-[9px] sm:text-xs md:text-sm
                                              mt-2 font-semibold
                                              leading-tight
                                              break-words"
                                        style="color:{{ $reached ? '#0F3D2E' : '#b7a67a' }}">

                                        {{ $label }}

                                    </p>

                                </div>

                            @endforeach

                        </div>


                        @if($isReady)

                            <p class="f-script
                                      text-xl sm:text-2xl
                                      text-center
                                      mt-4 px-2"
                                style="color:var(--green)">

                                Your food is hot and ready.
                                Show your token at the counter!

                            </p>

                        @endif

                    </div>


                    {{-- ================= TOTAL ================= --}}
                    <div class="mt-6
                                flex flex-col
                                sm:flex-row
                                sm:justify-between
                                sm:items-center
                                gap-4
                                pt-5"
                        style="border-top:2px dashed #f3e6c4">


                        <div class="flex flex-col sm:flex-row
                                    sm:items-center
                                    gap-1 sm:gap-2">

                            <span class="text-gray-500 text-sm">
                                Total amount
                            </span>

                            <span class="f-display
                                         font-extrabold
                                         text-2xl sm:text-3xl"
                                style="color:var(--green)">

                                ₹{{ number_format($order->total_amount, 2) }}

                            </span>

                        </div>


                        {{-- View Order --}}
                        <a href="{{ route('orders.show', $order) }}"
                            class="w-full sm:w-auto
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-1.5
                                   text-white
                                   px-5 py-3
                                   rounded-full
                                   font-bold
                                   text-sm sm:text-base
                                   hover:scale-105
                                   active:scale-95
                                   transition"
                            style="background:var(--green)">

                            View order →

                        </a>

                    </div>

                </article>


            @empty

                {{-- ================= NO ORDERS ================= --}}
                <div class="bg-white
                            rounded-2xl sm:rounded-3xl
                            p-6 sm:p-12
                            text-center"
                    style="border:2px solid #f3e6c4">

                    <p class="plate
                              text-6xl sm:text-7xl
                              inline-block"
                        aria-hidden="true">
                        🍱
                    </p>

                    <h2 class="f-display
                               text-2xl sm:text-3xl
                               font-extrabold mt-4"
                        style="color:var(--green)">
                        No orders yet
                    </h2>

                    <p class="text-gray-500
                              mt-2
                              text-sm sm:text-base
                              max-w-md mx-auto">

                        Hungry? Browse the canteen menu and
                        place your first order.

                    </p>


                    <a href="{{ route('food.index') }}"
                        class="w-full sm:w-auto
                               inline-flex
                               items-center
                               justify-center
                               gap-2
                               mt-6
                               font-bold
                               px-7 py-3
                               rounded-full
                               shadow-md
                               hover:scale-105
                               active:scale-95
                               transition"
                        style="background:var(--yellow); color:var(--green)">

                        🍔 Browse food

                    </a>

                </div>

            @endforelse

        </div>

    </main>

</body>

</html>
