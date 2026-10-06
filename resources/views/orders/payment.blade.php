<x-app-layout>

    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md" style="background:#FBB017">
                💳
            </div>
            <h2 class="font-bold text-xl leading-tight" style="color:#0F3D2E">
                Payment
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap');

        [x-cloak] { display:none !important; }

        .pay { --green:#0F3D2E; --yellow:#FBB017; --leaf:#7BA23F; --cream:#FFFBF0; font-family:'Nunito',system-ui,sans-serif; }
        .pay .f-display { font-family:'Baloo 2','Nunito',sans-serif; }
        .pay .f-script  { font-family:'Caveat','Nunito',cursive; }

        /* heading entrance */
        .pay .pop { opacity:0; transform:translateY(20px) scale(.97); animation:payPop .6s cubic-bezier(.2,.9,.3,1.2) forwards; }
        .pay .d1{animation-delay:.05s} .pay .d2{animation-delay:.2s} .pay .d3{animation-delay:.35s}
        @keyframes payPop { to { opacity:1; transform:none; } }

        .pay .leaf { position:absolute; animation:payFloat 7s ease-in-out infinite; }
        .pay .leaf.l2 { animation-duration:9s; animation-delay:-3s; }
        @keyframes payFloat { 0%,100%{transform:translateY(0) rotate(-8deg)} 50%{transform:translateY(-12px) rotate(8deg)} }

        /* scanner line sweeps over the QR code */
        .pay .qr { position:relative; overflow:hidden; }
        .pay .qr::after { content:''; position:absolute; left:0; right:0; top:0; height:3px;
            background:linear-gradient(90deg,transparent,#FBB017,transparent);
            box-shadow:0 0 14px 2px rgba(251,176,23,.8); animation:payScan 2.6s ease-in-out infinite; }
        @keyframes payScan { 0%,100%{top:2%} 50%{top:96%} }

        .pay .corner { position:absolute; width:22px; height:22px; border:4px solid var(--green); }
        .pay .c1{top:0;left:0;border-right:0;border-bottom:0;border-top-left-radius:12px}
        .pay .c2{top:0;right:0;border-left:0;border-bottom:0;border-top-right-radius:12px}
        .pay .c3{bottom:0;left:0;border-right:0;border-top:0;border-bottom-left-radius:12px}
        .pay .c4{bottom:0;right:0;border-left:0;border-top:0;border-bottom-right-radius:12px}

        .pay .spin { width:20px; height:20px; border:3px solid rgba(15,61,46,.25); border-top-color:var(--green); border-radius:50%; animation:paySpin .7s linear infinite; }
        @keyframes paySpin { to { transform:rotate(360deg); } }

        .pay .item { transition:background .2s ease; }
        .pay .item:hover { background:#fffaf0; }

        .pay input:focus { border-color:var(--green); box-shadow:0 0 0 4px rgba(251,176,23,.35); outline:none; }
        .pay :focus-visible { outline:3px solid var(--yellow); outline-offset:3px; }

        @media (prefers-reduced-motion: reduce) {
            .pay *, .pay *::before, .pay *::after { animation:none !important; transition:none !important; }
            .pay .pop { opacity:1; transform:none; }
        }
    </style>

    @php
        // Change these two lines when you get the real canteen UPI details
        $upiId   = '123445552@upi';
        $payee   = 'Adhi College Canteen';

        $upiLink = 'upi://pay?pa=' . urlencode($upiId)
                 . '&pn=' . urlencode($payee)
                 . '&am=' . number_format($total, 2, '.', '')
                 . '&cu=INR&tn=' . urlencode('Canteen order');
    @endphp


    <div class="pay min-h-screen pb-16" style="background:var(--cream)">

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

            <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-10 pb-4 text-center">
                <h1 class="pop d1 f-display text-3xl sm:text-5xl font-extrabold text-white leading-tight">
                    Complete your payment
                </h1>
                <p class="pop d2 f-script text-2xl sm:text-3xl mt-1" style="color:var(--yellow)">
                    Almost there. Your food is next!
                </p>
            </div>

            <svg class="block w-full h-8 sm:h-10 mt-2" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 40V18C240 -6 480 -6 720 14s480 20 720 -4v30z" fill="#FFFBF0"/>
            </svg>
        </section>


        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

                {{-- ================= ORDER ITEMS ================= --}}
                <div class="lg:col-span-3 bg-white rounded-3xl overflow-hidden" style="border:2px solid #f3e6c4">

                    <div class="px-6 py-5" style="border-bottom:2px dashed #f3e6c4">
                        <h2 class="f-display text-2xl font-extrabold" style="color:var(--green)">
                            Your order
                        </h2>
                    </div>

                    <div>
                        @foreach($cart as $item)
                            <div class="item p-5 flex items-center gap-4" style="{{ !$loop->last ? 'border-bottom:1px solid #f7efd6' : '' }}">

                                <div class="w-20 h-20 rounded-2xl overflow-hidden flex items-center justify-center shrink-0"
                                     style="background:linear-gradient(135deg,#FDE9A8,#FBB017)">
                                    @if(!empty($item['image']))
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-3xl" aria-hidden="true">🍽️</span>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="f-display text-lg font-extrabold truncate" style="color:var(--green)">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        ₹{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}
                                    </p>
                                </div>

                                <p class="f-display text-lg font-extrabold" style="color:var(--green)">
                                    ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </p>

                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-5 flex justify-between items-center" style="background:#fff7dd; border-top:2px dashed #f3e6c4">
                        <span class="font-bold" style="color:var(--green)">Total</span>
                        <span class="f-display text-2xl font-extrabold" style="color:var(--green)">₹{{ number_format($total, 2) }}</span>
                    </div>

                </div>


                {{-- ================= PAYMENT ================= --}}
                <aside class="lg:col-span-2 relative overflow-hidden rounded-3xl p-6 text-white lg:sticky lg:top-6"
                       style="background:var(--green); box-shadow:0 20px 40px -20px rgba(15,61,46,.7)">

                    <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full" style="background:rgba(251,176,23,.2)"></div>

                    <div class="relative">

                        <h2 class="f-display text-2xl font-extrabold">🧾 Pay ₹{{ number_format($total, 2) }}</h2>

                        {{-- Step 1: pay --}}
                        <p class="mt-5 text-sm font-bold" style="color:var(--yellow)">Step 1. Pay using any UPI app</p>

                        <div class="mt-3 bg-white rounded-3xl p-5 text-center" style="color:var(--green)">

                            <div class="inline-block relative p-4">
                                <span class="corner c1"></span><span class="corner c2"></span>
                                <span class="corner c3"></span><span class="corner c4"></span>
                                <div class="qr rounded-xl">
                                    <img src="{{ asset('images/qr.png') }}" alt="Canteen UPI QR code"
                                         class="w-52 h-52 object-contain">
                                </div>
                            </div>

                            <p class="text-sm text-gray-500 mt-3">UPI ID</p>

                            <div class="mt-1 flex items-center justify-center gap-2"
                                 x-data="{ copied: false }">
                                <p class="font-extrabold text-lg break-all">{{ $upiId }}</p>

                                <button type="button"
                                        @click="navigator.clipboard.writeText('{{ $upiId }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                        class="shrink-0 text-sm font-bold px-3 py-1 rounded-full transition"
                                        :style="copied ? 'background:#e4f0cf;color:#0F3D2E' : 'background:#FDE9A8;color:#0F3D2E'"
                                        aria-live="polite">
                                    <span x-show="!copied">Copy</span>
                                    <span x-show="copied" x-cloak>Copied ✓</span>
                                </button>
                            </div>

                            <div class="mt-4 rounded-2xl p-4" style="background:#fff7dd">
                                <p class="text-sm text-gray-500">Amount to pay</p>
                                <p class="f-display text-4xl font-extrabold leading-tight">₹{{ number_format($total, 2) }}</p>
                            </div>

                            {{-- On a phone you can't scan your own screen, so open the UPI app directly --}}
                            <a href="{{ $upiLink }}"
                               class="lg:hidden mt-4 w-full inline-flex items-center justify-center gap-2 py-3 rounded-full font-extrabold"
                               style="background:var(--yellow); color:var(--green)">
                                📱 Open UPI app
                            </a>

                        </div>


                        {{-- Step 2: confirm --}}
                        <form action="{{ route('orders.payment.submit') }}" method="POST" class="mt-6"
                              x-data="{ sending: false }" @submit="sending = true">
                            @csrf

                            <p class="text-sm font-bold" style="color:var(--yellow)">Step 2. Enter your transaction ID</p>

                            <label for="payment_reference" class="block text-sm mt-2 mb-2" style="color:#cfe6da">
                                UTR / Transaction ID (shown after payment)
                            </label>

                            <input type="text"
                                   id="payment_reference"
                                   name="payment_reference"
                                   value="{{ old('payment_reference') }}"
                                   placeholder="e.g. 412345678901"
                                   autocomplete="off"
                                   class="w-full rounded-xl border-0 px-4 py-3 text-gray-800 placeholder-gray-400
                                          {{ $errors->has('payment_reference') ? 'ring-4 ring-red-400' : '' }}"
                                   required>

                            @error('payment_reference')
                                <p class="mt-2 text-sm font-semibold rounded-lg px-3 py-2" style="background:#fde2df; color:#9b1c1c" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror

                            <button type="submit" :disabled="sending"
                                    class="mt-5 w-full py-3.5 rounded-full font-extrabold text-lg shadow-lg
                                           flex items-center justify-center gap-2
                                           hover:scale-[1.03] active:scale-[.97] transition disabled:opacity-80"
                                    style="background:var(--yellow); color:var(--green)">
                                <template x-if="!sending"><span>Submit payment</span></template>
                                <template x-if="sending"><span class="flex items-center gap-2"><span class="spin"></span> Submitting...</span></template>
                            </button>

                            <p class="text-xs mt-3 text-center" style="color:#9fc7b5">
                                The canteen verifies your payment, then your order starts.
                            </p>
                        </form>


                        <a href="{{ route('cart.index') }}"
                           class="mt-5 w-full inline-flex items-center justify-center gap-2 py-3 rounded-full font-bold transition
                                  bg-white/10 hover:bg-white/20 border border-white/25">
                            ← Back to cart
                        </a>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-app-layout>
