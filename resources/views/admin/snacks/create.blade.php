<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Snack - College Canteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family:'Poppins',sans-serif; }
        .font-display { font-family:'Baloo 2',cursive; }

        @keyframes gradient-move { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        .hero-bg { background:linear-gradient(120deg,#0b4a35,#06301f,#0f6b4b,#06301f); background-size:300% 300%; animation:gradient-move 14s ease infinite; }

        @keyframes floaty { 0%,100%{transform:translateY(0) rotate(-4deg)} 50%{transform:translateY(-12px) rotate(8deg)} }
        .floaty { animation:floaty 5s ease-in-out infinite; }

        @keyframes bob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        .bob { animation:bob 2.4s ease-in-out infinite; }

        @keyframes rise { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }
        .rise { animation:rise .55s cubic-bezier(.2,.8,.2,1) both; }

        @keyframes shine { to{transform:translateX(250%) skewX(-20deg)} }
        .btn-shine { position:relative; overflow:hidden; }
        .btn-shine::after { content:'';position:absolute;inset:0 auto 0 -60%;width:40%;background:rgba(255,255,255,.45);transform:skewX(-20deg);animation:shine 3.2s ease-in-out infinite; }

        .ripple { position:relative; overflow:hidden; }
        .ripple-wave { position:absolute; border-radius:9999px; background:rgba(255,255,255,.5); transform:scale(0); animation:ripple .6s linear; pointer-events:none; }
        @keyframes ripple { to{transform:scale(4);opacity:0} }

        @keyframes wiggle { 0%,100%{transform:rotate(0)} 20%{transform:rotate(-18deg) scale(1.15)} 40%{transform:rotate(14deg) scale(1.15)} 60%{transform:rotate(-10deg)} 80%{transform:rotate(6deg)} }

        @keyframes pop-in { 0%{opacity:0;transform:scale(.85)} 100%{opacity:1;transform:scale(1)} }
        .pop-in { animation:pop-in .3s cubic-bezier(.2,.8,.2,1) both; }

        @keyframes shake { 0%,100%{transform:translateX(0)} 20%,60%{transform:translateX(-6px)} 40%,80%{transform:translateX(6px)} }
        .shake { animation:shake .5s ease; }

        @keyframes spin { to{transform:rotate(360deg)} }
        .spinner { width:18px;height:18px;border:3px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:9999px;animation:spin .7s linear infinite; }

        .field { transition:border-color .2s, box-shadow .2s, background .2s; }
        .field:focus { outline:none; border-color:#0b4a35; box-shadow:0 0 0 4px rgba(249,201,16,.45); background:#fff; }

        .drop { transition:all .25s; }
        .drop.over { border-color:#0b4a35; background:#FFF6D6; transform:scale(1.02); }

        .cat-chip { transition:all .2s; }
        .cat-chip:hover { transform:translateY(-3px); }
        input:checked + .cat-chip { background:#0b4a35; color:#fff; border-color:#0b4a35; transform:scale(1.05); box-shadow:0 10px 18px -8px rgba(11,74,53,.6); }
        input:checked + .cat-chip .cat-emoji { animation:wiggle .6s ease; }

        .toggle-track { transition:background .25s; }
        .toggle-knob { transition:transform .25s cubic-bezier(.2,.8,.2,1); }
        input:checked ~ .toggle-track { background:#0b4a35; }
        input:checked ~ .toggle-track .toggle-knob { transform:translateX(24px); }

        .preview-price { transition:transform .25s; }
        .preview-price.bump { transform:scale(1.2) rotate(-4deg); }

        @media (prefers-reduced-motion:reduce){ *,*::before,*::after{animation:none!important;transition:none!important} }
    </style>
</head>

<body class="bg-gradient-to-b from-[#eef5ea] to-[#f7f9f4] min-h-screen">

    <!-- Header -->
    <header class="hero-bg relative overflow-hidden text-white shadow-lg">
        <div class="absolute -right-10 -top-16 w-64 h-64 rounded-full bg-[#f9c910]/15"></div>
        <span class="floaty absolute right-[25%] top-4 text-3xl opacity-40 hidden md:block">🍟</span>
        <span class="floaty absolute right-[14%] bottom-3 text-3xl opacity-40 hidden md:block" style="animation-delay:-2s">🍔</span>
        <span class="floaty absolute left-[50%] top-3 text-2xl opacity-30 hidden lg:block" style="animation-delay:-1s">☕</span>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-3 py-6">
                <div class="flex items-center gap-4">
                    <div class="bob w-14 h-14 rounded-2xl bg-[#f9c910] text-[#0b4a35] grid place-items-center text-3xl shadow-lg shrink-0">➕</div>
                    <div>
                        <p class="text-sm text-white/70">Admin Panel</p>
                        <h1 class="font-display text-3xl sm:text-4xl font-extrabold leading-none mt-1">Add New Snack</h1>
                    </div>
                </div>

                <a href="{{ route('admin.snacks.index') }}"
                   class="ripple group bg-white/10 border border-white/20 text-white font-semibold px-4 py-2.5 rounded-xl hover:bg-white/20 transition active:scale-95 shrink-0">
                    <span class="inline-block transition-transform group-hover:-translate-x-1">←</span> Back
                </a>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">

            <!-- ============ FORM ============ -->
            <div class="rise lg:col-span-3 bg-white rounded-2xl shadow-sm border border-[#dfe8db] p-6 sm:p-8">

                <div class="mb-6 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-[#FFF6D6] grid place-items-center text-2xl">📝</div>
                    <div>
                        <h2 class="font-display text-2xl font-extrabold text-[#0b4a35] leading-none">Food Information</h2>
                        <p class="text-gray-500 text-sm mt-1">Add a food item that will be shown to students.</p>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="shake mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">
                        <p class="font-bold mb-2">⚠️ Please fix the following errors:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="snackForm" action="{{ route('admin.snacks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">🍽️ Food Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Example: Dosa" required
                               class="field w-full border border-gray-300 bg-[#f7f9f4] rounded-xl px-4 py-3">
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <label for="description" class="block text-sm font-bold text-gray-700">💬 Description</label>
                            <span class="text-xs text-gray-400"><span id="descCount">0</span> chars</span>
                        </div>
                        <textarea id="description" name="description" rows="4" placeholder="Example: Crispy dosa served with chutney and sambar"
                                  class="field w-full border border-gray-300 bg-[#f7f9f4] rounded-xl px-4 py-3">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-5">
                        <label for="price" class="block text-sm font-bold text-gray-700 mb-2">💰 Price (₹)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-[#0b4a35]">₹</span>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="50" min="0" step="0.01" required
                                   class="field w-full border border-gray-300 bg-[#f7f9f4] rounded-xl pl-9 pr-4 py-3">
                        </div>
                        @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-5">
                        <p class="block text-sm font-bold text-gray-700 mb-2">🏷️ Category</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach([['Breakfast','🥞'],['Lunch','🍛'],['Snacks','🍟'],['Beverages','☕']] as $c)
                                <label class="cursor-pointer">
                                    <input type="radio" name="category" value="{{ $c[0] }}" class="hidden peer-cat" {{ old('category') == $c[0] ? 'checked' : '' }} required>
                                    <span class="cat-chip flex flex-col items-center gap-1 border border-gray-300 bg-[#f7f9f4] rounded-xl py-3 text-sm font-semibold text-gray-700">
                                        <span class="cat-emoji text-2xl">{{ $c[1] }}</span>
                                        {{ $c[0] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-5">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">📷 Food Image</label>

                        <label id="dropzone" for="image"
                               class="drop flex flex-col items-center justify-center text-center gap-1 border-2 border-dashed border-gray-300 bg-[#f7f9f4] rounded-xl px-4 py-7 cursor-pointer hover:border-[#0b4a35] hover:bg-[#FFF6D6]">
                            <span id="dropIcon" class="bob text-4xl">📤</span>
                            <span id="dropText" class="font-semibold text-[#0b4a35] text-sm">Click to upload or drag &amp; drop</span>
                            <span class="text-xs text-gray-500">JPG, JPEG, PNG or WEBP. Maximum 2MB.</span>
                        </label>
                        <input type="file" id="image" name="image" accept="image/*" class="hidden">

                        @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Availability -->
                    <div class="mb-7 flex items-center justify-between gap-4 bg-[#f7f9f4] border border-[#dfe8db] rounded-xl p-4">
                        <div>
                            <p class="font-semibold text-gray-700">Food is available</p>
                            <p class="text-xs text-gray-500 mt-0.5">Students can add this food to their cart when it is available.</p>
                        </div>
                        <label class="relative cursor-pointer shrink-0">
                            <input type="checkbox" id="available" name="is_available" value="1" class="hidden"
                                   {{ old('is_available', true) ? 'checked' : '' }}>
                            <span class="toggle-track block w-[52px] h-7 rounded-full bg-gray-300 relative">
                                <span class="toggle-knob absolute top-0.5 left-0.5 w-6 h-6 rounded-full bg-white shadow"></span>
                            </span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button id="submitBtn" type="submit"
                                class="btn-shine ripple flex-1 inline-flex items-center justify-center gap-2 bg-[#0b4a35] text-white font-bold px-5 py-3 rounded-xl hover:bg-[#083d2c] transition hover:scale-[1.02] active:scale-95">
                            <span id="submitText">➕ Add Snack</span>
                        </button>

                        <a href="{{ route('admin.snacks.index') }}"
                           class="ripple flex-1 text-center bg-gray-100 text-gray-700 font-bold px-5 py-3 rounded-xl hover:bg-gray-200 transition active:scale-95">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- ============ LIVE PREVIEW ============ -->
            <aside class="rise lg:col-span-2 lg:sticky lg:top-6" style="animation-delay:.15s">
                <p class="text-sm font-bold text-[#0b4a35] mb-3 flex items-center gap-2">
                    👀 Live preview
                    <span class="text-xs font-normal text-gray-400">How students will see it</span>
                </p>

                <div class="bg-white rounded-2xl border border-gray-200 shadow-md overflow-hidden">
                    <div class="relative h-52 bg-gradient-to-br from-[#eef5ea] to-[#FFF6D6] overflow-hidden">
                        <img id="pvImg" src="" alt="" class="hidden w-full h-full object-cover pop-in">
                        <div id="pvEmoji" class="w-full h-full flex items-center justify-center text-7xl bob">🍛</div>

                        <span id="pvAvail" class="absolute top-3 left-3 inline-flex items-center gap-1.5 bg-white/95 text-green-700 text-xs font-bold px-3 py-1 rounded-full shadow">
                            <span id="pvDot" class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span id="pvAvailText">Available</span>
                        </span>

                        <div id="pvPrice" class="preview-price absolute bottom-3 right-3 bg-[#f9c910] text-[#0b4a35] font-display font-extrabold text-xl px-3.5 py-1 rounded-xl shadow-lg">₹0.00</div>
                    </div>

                    <div class="p-5">
                        <span id="pvCat" class="hidden bg-[#fff6d6] text-[#8a5b12] text-xs font-semibold px-3 py-1 rounded-full mb-3 inline-block"></span>
                        <h3 id="pvName" class="font-display text-xl font-extrabold text-[#0b4a35] leading-tight">Food name</h3>
                        <p id="pvDesc" class="text-sm text-gray-500 mt-2 min-h-[40px]">No description available.</p>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-3 text-center">Preview updates as you type ✨</p>
            </aside>

        </div>
    </main>

    <script>
        const $ = id => document.getElementById(id);
        const name = $('name'), desc = $('description'), price = $('price'), img = $('image'), avail = $('available');

        // ---------- Live preview ----------
        function renderText() {
            $('pvName').textContent = name.value.trim() || 'Food name';
            $('pvDesc').textContent = desc.value.trim() || 'No description available.';
            $('descCount').textContent = desc.value.length;
        }
        function renderPrice() {
            const v = parseFloat(price.value) || 0;
            const el = $('pvPrice');
            el.textContent = '₹' + v.toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2});
            el.classList.add('bump'); setTimeout(() => el.classList.remove('bump'), 180);
        }
        function renderCat() {
            const c = document.querySelector('input[name="category"]:checked');
            const el = $('pvCat');
            if (c) { el.textContent = c.value; el.classList.remove('hidden'); } else { el.classList.add('hidden'); }
        }
        function renderAvail() {
            const on = avail.checked;
            $('pvAvailText').textContent = on ? 'Available' : 'Unavailable';
            $('pvAvail').className = 'absolute top-3 left-3 inline-flex items-center gap-1.5 bg-white/95 text-xs font-bold px-3 py-1 rounded-full shadow ' + (on ? 'text-green-700' : 'text-red-700');
            $('pvDot').className = 'w-2 h-2 rounded-full ' + (on ? 'bg-emerald-500' : 'bg-red-500');
            $('pvImg').classList.toggle('grayscale', !on);
            $('pvImg').classList.toggle('opacity-70', !on);
        }

        name.addEventListener('input', renderText);
        desc.addEventListener('input', renderText);
        price.addEventListener('input', renderPrice);
        avail.addEventListener('change', renderAvail);
        document.querySelectorAll('input[name="category"]').forEach(r => r.addEventListener('change', renderCat));

        // ---------- Image preview + drag & drop ----------
        function showFile(file) {
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                $('pvImg').src = e.target.result;
                $('pvImg').classList.remove('hidden');
                $('pvEmoji').classList.add('hidden');
                $('dropIcon').textContent = '✅';
                $('dropText').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
        img.addEventListener('change', () => showFile(img.files[0]));

        const dz = $('dropzone');
        ['dragenter','dragover'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.add('over'); }));
        ['dragleave','drop'].forEach(ev => dz.addEventListener(ev, e => { e.preventDefault(); dz.classList.remove('over'); }));
        dz.addEventListener('drop', e => {
            if (e.dataTransfer.files.length) { img.files = e.dataTransfer.files; showFile(img.files[0]); }
        });

        // ---------- Submit loading state ----------
        $('snackForm').addEventListener('submit', () => {
            const b = $('submitBtn');
            b.classList.add('opacity-80', 'pointer-events-none');
            $('submitText').innerHTML = '<span class="spinner inline-block align-middle mr-2"></span>Adding...';
        });

        // ---------- Ripple ----------
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

        // Initial render (keeps old() values in preview)
        renderText(); renderCat(); renderAvail();
        if (price.value) renderPrice();
    </script>

</body>
</html>
