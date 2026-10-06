<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-bold text-xl leading-tight" style="color:#0F3D2E">
            My Cart
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap');

        [x-cloak] { display:none !important; }

        .ct { --green:#0F3D2E; --yellow:#FBB017; --leaf:#7BA23F; --cream:#FFFBF0; font-family:'Nunito',system-ui,sans-serif; }
        .ct .f-display { font-family:'Baloo 2','Nunito',sans-serif; }
        .ct .f-script  { font-family:'Caveat','Nunito',cursive; }

        /* banner entrance */
        .ct .pop { opacity:0; transform:translateY(20px) scale(.97); animation:ctPop .6s cubic-bezier(.2,.9,.3,1.2) forwards; }
        .ct .d1{animation-delay:.05s} .ct .d2{animation-delay:.2s} .ct .d3{animation-delay:.35s}
        @keyframes ctPop { to { opacity:1; transform:none; } }

        .ct .leaf { position:absolute; animation:ctFloat 7s ease-in-out infinite; }
        .ct .leaf.l2 { animation-duration:9s; animation-delay:-3s; }
        @keyframes ctFloat { 0%,100%{transform:translateY(0) rotate(-8deg)} 50%{transform:translateY(-12px) rotate(8deg)} }

        .ct .plate { animation:ctWobble 2.6s ease-in-out infinite; transform-origin:50% 90%; }
        @keyframes ctWobble { 0%,100%{transform:rotate(-6deg)} 50%{transform:rotate(6deg)} }

        .ct .row { transition:transform .25s ease, box-shadow .25s ease, opacity .3s ease; }
        .ct .row:hover { transform:translateY(-3px); box-shadow:0 14px 26px -16px rgba(15,61,46,.45); }
        .ct .step { transition:background .15s ease, transform .15s ease; }
        .ct .step:hover { background:var(--yellow); }
        .ct .step:active { transform:scale(.88); }
        .ct .spin { width:20px; height:20px; border:3px solid rgba(15,61,46,.25); border-top-color:var(--green); border-radius:50%; animation:ctSpin .7s linear infinite; }
        @keyframes ctSpin { to { transform:rotate(360deg); } }
        @keyframes toast-progress { from { width:100%; } to { width:0%; } }

        .ct :focus-visible { outline:3px solid var(--yellow); outline-offset:3px; }

        @media (prefers-reduced-motion: reduce) {
            .ct *, .ct *::before { animation:none !important; transition:none !important; }
            .ct .pop { opacity:1; transform:none; }
        }
    </style>

    @php
        $itemCount = collect($cart ?? [])->sum('quantity');
    @endphp


    <div class="ct pb-16 min-h-screen" style="background:var(--cream)">

        {{-- ================= BANNER ================= --}}
        <section class="relative overflow-hidden" style="background:var(--green)">

            <div class="absolute inset-0 opacity-10"
                 style="background-image:radial-gradient(circle at 2px 2px,#fff 1px,transparent 0);background-size:24px 24px"></div>

            <svg class="leaf" style="left:3%;top:14px" width="40" height="52" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#7BA23F"/>
            </svg>
            <svg class="leaf l2 hidden sm:block" style="right:8%;top:20px" width="34" height="44" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#FBB017"/>
            </svg>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-4 relative">

                <div class="flex items-center gap-4">
                    <div class="pop d1 w-14 h-14 rounded-full flex items-center justify-center text-2xl shadow-lg"
                         style="background:var(--yellow)">
                        🛒
                    </div>

                    <div>
                        <h1 class="pop d2 f-display text-3xl sm:text-5xl font-extrabold text-white leading-tight">
                            Your order
                        </h1>

                        <p class="pop d3 mt-0.5" style="color:#cfe6da">
                            @if(empty($cart))
                                Nothing here yet.
                            @else
                                <span class="inline-flex items-center gap-2">
                                    <span class="text-xs font-extrabold px-2.5 py-0.5 rounded-full"
                                          style="background:var(--yellow); color:var(--green)">
                                        {{ $itemCount }}
                                    </span>
                                    {{ \Illuminate\Support\Str::plural('item', $itemCount) }} ready to go
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

            </div>

            <svg class="block w-full h-8 sm:h-10 mt-2" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 40V18C240 -6 480 -6 720 14s480 20 720 -4v30z" fill="#FFFBF0"/>
            </svg>
        </section>


        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Success Toast --}}
            @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transform ease-out duration-300 transition"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transform ease-in duration-300 transition"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"
                    x-init="setTimeout(() => show = false, 4000)"
                    role="status"
                    class="fixed top-6 right-6 z-50 w-[calc(100%-2rem)] max-w-sm"
                >
                    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" style="border:2px solid #c8e1a3">

                        <div class="flex items-start gap-4 p-4">
                            <div class="shrink-0 w-11 h-11 rounded-full flex items-center justify-center" style="background:#e4f0cf">
                                <svg class="w-6 h-6" style="color:var(--leaf)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="f-display font-extrabold text-lg" style="color:var(--green)">Done!</h3>
                                <p class="text-sm text-gray-600">{{ session('success') }}</p>
                            </div>

                            <button type="button" @click="show = false" aria-label="Close" class="text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="h-1.5" style="background:#e4f0cf">
                            <div class="h-full" style="background:var(--yellow); animation:toast-progress 4s linear forwards;"></div>
                        </div>

                    </div>
                </div>
            @endif


            @if(empty($cart))

                {{-- Empty cart --}}
                <div class="mt-4 bg-white rounded-3xl p-12 text-center" style="border:2px solid #f3e6c4">

                    <p class="plate text-7xl inline-block" aria-hidden="true">🍽️</p>

                    <h2 class="f-display text-3xl font-extrabold mt-4" style="color:var(--green)">
                        Your cart is empty
                    </h2>

                    <p class="f-script text-2xl mt-1" style="color:var(--leaf)">Good Food • Great Mood</p>

                    <p class="text-gray-500 mt-2">
                        Add a snack from the menu to start your order.
                    </p>

                    <a href="{{ route('food.index') }}"
                       class="inline-flex items-center gap-2 mt-6 font-bold px-7 py-3 rounded-full shadow-md
                              hover:scale-105 active:scale-95 transition"
                       style="background:var(--yellow); color:var(--green)">
                        🍔 Browse food
                    </a>

                </div>

            @else

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                    {{-- Cart items --}}
                    <div class="lg:col-span-2 space-y-4">

                        @foreach($cart as $item)

                            <article class="row bg-white rounded-3xl p-4 sm:p-5"
                                     style="border:2px solid #f3e6c4"
                                     x-data="{ removing: false }"
                                     :class="removing ? 'opacity-40 scale-[.98]' : ''">

                                <div class="flex gap-4">

                                    {{-- Thumbnail --}}
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 rounded-2xl overflow-hidden flex items-center justify-center"
                                         style="background:linear-gradient(135deg,#FDE9A8,#FBB017)">

                                        @if(!empty($item['image']))
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <span class="text-3xl" aria-hidden="true">🍽️</span>
                                        @endif

                                    </div>


                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0">

                                        <div class="flex items-start justify-between gap-3">

                                            <div class="min-w-0">
                                                <h2 class="f-display text-xl font-extrabold leading-snug truncate" style="color:var(--green)">
                                                    {{ $item['name'] }}
                                                </h2>

                                                <p class="text-sm text-gray-500 mt-0.5">
                                                    ₹{{ number_format($item['price'], 2) }} each
                                                </p>
                                            </div>

                                            <p class="shrink-0 f-display text-xl font-extrabold" style="color:var(--green)">
                                                ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </p>

                                        </div>


                                        <div class="flex items-center justify-between mt-4">

                                            {{-- Quantity stepper --}}
                                            <div class="inline-flex items-center rounded-full p-1" style="background:#f7efd6">

                                                <form action="{{ route('cart.decrease', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            aria-label="Decrease quantity of {{ $item['name'] }}"
                                                            class="step w-9 h-9 rounded-full bg-white font-bold shadow-sm"
                                                            style="color:var(--green)">
                                                        −
                                                    </button>
                                                </form>

                                                <span class="w-10 text-center font-extrabold" style="color:var(--green)">
                                                    {{ $item['quantity'] }}
                                                </span>

                                                <form action="{{ route('cart.increase', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            aria-label="Increase quantity of {{ $item['name'] }}"
                                                            class="step w-9 h-9 rounded-full bg-white font-bold shadow-sm"
                                                            style="color:var(--green)">
                                                        +
                                                    </button>
                                                </form>

                                            </div>


                                            {{-- Remove --}}
                                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST"
                                                  @submit="removing = true">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500
                                                               hover:text-red-600 focus:underline transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4h6v3m-8 0 1 13h8l1-13"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </article>

                        @endforeach


                        <a href="{{ route('food.index') }}"
                           class="inline-flex items-center justify-center gap-2 font-bold px-6 py-3 rounded-full
                                  hover:bg-white transition"
                           style="border:2px solid var(--green); color:var(--green)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l-7-7 7-7M19 12H5" />
                            </svg>
                            Add more food
                        </a>

                    </div>


                    {{-- Order summary --}}
                    <aside class="relative overflow-hidden rounded-3xl p-6 text-white lg:sticky lg:top-6"
                           style="background:var(--green); box-shadow:0 20px 40px -20px rgba(15,61,46,.7)">

                        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full" style="background:rgba(251,176,23,.2)"></div>

                        <div class="relative">

                            <h2 class="f-display text-2xl font-extrabold flex items-center gap-2">
                                🧾 Order summary
                            </h2>

                            <dl class="mt-5 space-y-3" style="color:#cfe6da">
                                <div class="flex justify-between">
                                    <dt>Items</dt>
                                    <dd class="text-white font-semibold">{{ $itemCount }}</dd>
                                </div>

                                <div class="flex justify-between">
                                    <dt>Subtotal</dt>
                                    <dd class="text-white font-semibold">₹{{ number_format($total, 2) }}</dd>
                                </div>
                            </dl>

                            {{-- dashed receipt line --}}
                            <div class="mt-5 pt-5 flex justify-between items-center" style="border-top:2px dashed rgba(255,255,255,.3)">
                                <span class="text-lg font-semibold">Total</span>

                                {{-- total counts up once on load --}}
                                <span class="f-display text-4xl font-extrabold" style="color:var(--yellow)"
                                      x-data="{ n: 0, target: {{ (float) $total }} }"
                                      x-init="
                                          if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { n = target; return; }
                                          const t0 = performance.now();
                                          const tick = (t) => {
                                              const p = Math.min((t - t0) / 700, 1);
                                              n = target * (1 - Math.pow(1 - p, 3));
                                              if (p < 1) requestAnimationFrame(tick); else n = target;
                                          };
                                          requestAnimationFrame(tick);
                                      "
                                      x-text="'₹' + n.toFixed(2)">
                                    ₹{{ number_format($total, 2) }}
                                </span>
                            </div>


                            {{-- Proceed to payment --}}
                            <a href="{{ route('orders.payment') }}"
                               x-data="{ going: false }"
                               @click="going = true"
                               class="mt-6 w-full inline-flex items-center justify-center gap-2 py-3.5 rounded-full
                                      font-extrabold text-lg shadow-lg hover:scale-[1.03] active:scale-[.97] transition"
                               style="background:var(--yellow); color:var(--green)">
                                <template x-if="!going"><span>🚀 Proceed to payment</span></template>
                                <template x-if="going"><span class="flex items-center gap-2"><span class="spin"></span> Please wait...</span></template>
                            </a>

                            <p class="text-xs mt-3 text-center" style="color:#9fc7b5">
                                Pay at pickup counter
                            </p>

                        </div>

                    </aside>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
