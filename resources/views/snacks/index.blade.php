<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Caveat:wght@600;700&family=Nunito:wght@400;600;700&display=swap');

        [x-cloak] { display:none !important; }

        .fd { --green:#0F3D2E; --yellow:#FBB017; --leaf:#7BA23F; --cream:#FFFBF0; font-family:'Nunito',system-ui,sans-serif; }
        .fd .f-display { font-family:'Baloo 2','Nunito',sans-serif; }
        .fd .f-script  { font-family:'Caveat','Nunito',cursive; }

        /* hero entrance: the one orchestrated moment */
        .fd .pop { opacity:0; transform:translateY(22px) scale(.97); animation:fdPop .65s cubic-bezier(.2,.9,.3,1.2) forwards; }
        .fd .d1{animation-delay:.05s} .fd .d2{animation-delay:.2s} .fd .d3{animation-delay:.35s} .fd .d4{animation-delay:.5s}
        @keyframes fdPop { to { opacity:1; transform:none; } }

        .fd .leaf { position:absolute; animation:fdFloat 7s ease-in-out infinite; }
        .fd .leaf.l2 { animation-duration:9s; animation-delay:-3s; }
        @keyframes fdFloat { 0%,100%{transform:translateY(0) rotate(-8deg)} 50%{transform:translateY(-12px) rotate(8deg)} }

        /* cards respond to the person's action */
        .fd .card { transition:transform .25s ease, box-shadow .25s ease; }
        .fd .card:hover { transform:translateY(-6px); box-shadow:0 18px 30px -16px rgba(15,61,46,.45); }
        .fd .card img { transition:transform .5s ease; }
        .fd .card:hover img { transform:scale(1.08); }

        .fd .add-btn { transition:background .2s ease, transform .15s ease; }
        .fd .add-btn:active { transform:scale(.95); }
        .fd .spin { width:18px; height:18px; border:3px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:fdSpin .7s linear infinite; }
        @keyframes fdSpin { to { transform:rotate(360deg); } }

        .fd .chips::-webkit-scrollbar { display:none; }
        .fd :focus-visible { outline:3px solid var(--yellow); outline-offset:3px; }

        @media (prefers-reduced-motion: reduce) {
            .fd *, .fd *::before { animation:none !important; transition:none !important; }
            .fd .pop { opacity:1; transform:none; }
        }
    </style>

    <div
        class="fd pb-16 min-h-screen"
        style="background:var(--cream)"
        x-data="{
            q: '',
            cat: 'All',

            items: @js(
                $snacks->map(fn ($s) => [
                    'name' => strtolower($s->name),
                    'category' => $s->category ?? 'Other',
                ])->values()
            ),

            show(name, category) {
                return (
                    (this.cat === 'All' || this.cat === category) &&
                    name.includes(this.q.toLowerCase().trim())
                );
            },

            get count() {
                return this.items.filter(
                    item => this.show(item.name, item.category)
                ).length;
            }
        }"
    >

        {{-- ================= HERO ================= --}}
        <section class="relative overflow-hidden" style="background:var(--green)">

            <div class="absolute inset-0 opacity-10"
                 style="background-image:radial-gradient(circle at 2px 2px,#fff 1px,transparent 0);background-size:24px 24px"></div>

            <svg class="leaf" style="left:2%;top:18px" width="44" height="58" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#7BA23F"/>
            </svg>
            <svg class="leaf l2 hidden sm:block" style="right:6%;top:24px" width="38" height="48" viewBox="0 0 46 60" aria-hidden="true">
                <path d="M4 56C4 24 20 6 42 2c0 26-12 48-38 54z" fill="#FBB017"/>
            </svg>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

                <a href="{{ route('students.dashboard') }}"
                   class="pop d1 inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-semibold text-white
                          bg-white/10 hover:bg-white/20 border border-white/25 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>

                <p class="pop d2 f-script text-3xl mt-8" style="color:var(--yellow)">Good Food • Great Mood</p>

                <h1 class="pop d2 f-display font-extrabold text-white leading-[1.05] text-4xl sm:text-6xl max-w-2xl">
                    Hungry between classes?
                </h1>

                <p class="pop d3 text-lg mt-3 max-w-lg" style="color:#cfe6da">
                    Pick your snack, add it to the cart and grab it fresh.
                </p>

                {{-- SEARCH --}}
                <div class="pop d4 mt-8 max-w-lg">
                    <label for="food-search" class="sr-only">Search food</label>

                    <div class="flex items-center bg-white rounded-full pl-5 pr-2 py-2 shadow-lg
                                focus-within:ring-4 focus-within:ring-yellow-300 transition">

                        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path stroke-linecap="round" d="m20 20-3.5-3.5"></path>
                        </svg>

                        <input id="food-search" type="search" x-model="q"
                               placeholder="Search idli, vada, coffee..."
                               class="flex-1 border-0 focus:ring-0 text-gray-800 placeholder-gray-400 bg-transparent">

                        <button type="button" x-show="q" x-cloak @click="q = ''"
                                class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100"
                                aria-label="Clear search">
                            ✕
                        </button>
                    </div>
                </div>

            </div>

            {{-- wavy bottom edge, like the poster --}}
            <svg class="block w-full h-8 sm:h-10" viewBox="0 0 1440 40" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 40V18C240 -6 480 -6 720 14s480 20 720 -4v30z" fill="#FFFBF0"/>
            </svg>
        </section>


        {{-- ================= MAIN ================= --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 4000)"
                     x-transition.opacity role="status"
                     class="mt-4 flex items-center gap-3 rounded-2xl px-4 py-3 font-semibold"
                     style="background:#e4f0cf; color:var(--green); border:2px solid #c8e1a3">
                    <span aria-hidden="true">✅</span>
                    {{ session('success') }}
                </div>
            @endif


            {{-- CATEGORY FILTER --}}
            @php
                $categories = $snacks->pluck('category')->filter()->unique()->values();
            @endphp

            @if($categories->count() > 0)
                <div class="chips flex gap-2 overflow-x-auto py-5" style="scrollbar-width:none"
                     role="group" aria-label="Filter by category">

                    <button type="button" @click="cat = 'All'"
                            :class="cat === 'All'
                                ? 'text-[#0F3D2E] shadow-md scale-105'
                                : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:ring-[#7BA23F]'"
                            :style="cat === 'All' ? 'background:#FBB017' : ''"
                            class="shrink-0 px-5 py-2 rounded-full font-bold text-sm transition">
                        All
                    </button>

                    @foreach($categories as $category)
                        <button type="button" @click="cat = @js($category)"
                                :class="cat === @js($category)
                                    ? 'text-[#0F3D2E] shadow-md scale-105'
                                    : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:ring-[#7BA23F]'"
                                :style="cat === @js($category) ? 'background:#FBB017' : ''"
                                class="shrink-0 px-5 py-2 rounded-full font-bold text-sm transition">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="py-4"></div>
            @endif

            @if($snacks->count() > 0)
                <p class="text-sm font-semibold mb-4" style="color:#2b5a49" aria-live="polite">
                    <span x-text="count"></span>
                    <span x-text="count === 1 ? 'item' : 'items'"></span> available
                </p>
            @endif


            {{-- FOOD GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @forelse($snacks as $snack)

                    <article
                        x-show="show(@js(strtolower($snack->name)), @js($snack->category ?? 'Other'))"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-cloak
                        class="card bg-white rounded-3xl overflow-hidden flex flex-col"
                        style="border:2px solid #f3e6c4"
                    >

                        {{-- IMAGE --}}
                        <div class="relative h-48 overflow-hidden"
                             style="background:linear-gradient(135deg,#FDE9A8,#FBB017)">

                            @if($snack->image)
                                <img src="{{ asset('storage/' . $snack->image) }}" alt="{{ $snack->name }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-7xl" aria-hidden="true">🍽️</div>
                            @endif

                            @if($snack->category)
                                <span class="absolute top-3 left-3 text-xs font-bold px-3 py-1 rounded-full"
                                      style="background:rgba(255,251,240,.95); color:var(--green)">
                                    {{ $snack->category }}
                                </span>
                            @endif

                            <span class="absolute bottom-3 right-3 f-display font-extrabold text-lg px-4 py-0.5 rounded-full shadow"
                                  style="background:var(--yellow); color:var(--green)">
                                ₹{{ number_format($snack->price, 0) }}
                            </span>
                        </div>

                        {{-- DETAILS --}}
                        <div class="p-5 flex flex-col flex-1">

                            <h2 class="f-display text-xl font-extrabold leading-snug" style="color:var(--green)">
                                {{ $snack->name }}
                            </h2>

                            <p class="text-sm mt-1 line-clamp-2 {{ $snack->description ? 'text-gray-500' : 'text-gray-400' }}">
                                {{ $snack->description ?: 'Fresh and delicious.' }}
                            </p>

                            {{-- ADD TO CART --}}
                            <form action="{{ route('cart.add', $snack->id) }}" method="POST"
                                  class="mt-auto pt-5"
                                  x-data="{ adding: false }" @submit="adding = true">
                                @csrf

                                <button type="submit" :disabled="adding"
                                        class="add-btn w-full text-white py-3 rounded-full font-bold
                                               flex items-center justify-center gap-2 disabled:opacity-80"
                                        style="background:var(--green)"
                                        onmouseover="this.style.background='#17594a'"
                                        onmouseout="this.style.background='#0F3D2E'">

                                    <template x-if="!adding">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Add to cart
                                        </span>
                                    </template>

                                    <template x-if="adding">
                                        <span class="flex items-center gap-2"><span class="spin"></span> Adding...</span>
                                    </template>
                                </button>
                            </form>

                        </div>
                    </article>

                @empty

                    <div class="col-span-full text-center bg-white rounded-3xl p-12" style="border:2px solid #f3e6c4">
                        <p class="text-6xl" aria-hidden="true">🍽️</p>
                        <p class="f-display font-extrabold text-2xl mt-3" style="color:var(--green)">The menu is empty right now</p>
                        <p class="text-gray-500 mt-1">Check back soon for fresh items.</p>

                        <a href="{{ route('students.dashboard') }}"
                           class="inline-flex items-center gap-2 mt-6 text-white px-6 py-3 rounded-full font-bold transition hover:scale-105"
                           style="background:var(--green)">
                            ← Back to Dashboard
                        </a>
                    </div>

                @endforelse

            </div>


            {{-- NO SEARCH RESULT --}}
            @if($snacks->count() > 0)
                <div x-show="count === 0" x-cloak x-transition.opacity
                     class="mt-8 text-center bg-white rounded-3xl p-12" style="border:2px solid #f3e6c4">

                    <p class="text-5xl" aria-hidden="true">🔍</p>
                    <p class="f-display font-extrabold text-2xl mt-3" style="color:var(--green)">No food matches your search</p>
                    <p class="text-gray-500 mt-1">Try another name or pick a different category.</p>

                    <button type="button" @click="q = ''; cat = 'All'"
                            class="mt-5 font-bold px-6 py-2 rounded-full transition hover:scale-105"
                            style="background:var(--yellow); color:var(--green)">
                        Clear filters
                    </button>
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
