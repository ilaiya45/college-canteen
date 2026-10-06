<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-orange-50 via-amber-50 to-rose-50 text-gray-800">

    <div class="max-w-2xl mx-auto px-6 py-10">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Edit food</h1>
                <p class="text-sm text-gray-500 mt-1">Update the details for {{ $snack->name }}.</p>
            </div>

            <a href="{{ route('admin.snacks.index') }}"
               class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-200 px-4 py-2 rounded-full shadow-sm hover:bg-gray-50 hover:shadow transition focus:outline-none focus:ring-2 focus:ring-orange-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/60 ring-1 ring-orange-100 overflow-hidden">

            <div class="h-2 bg-gradient-to-r from-orange-400 via-amber-400 to-rose-400"></div>

            <div class="p-8">

                {{-- Errors --}}
                @if($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-xl">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc ml-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.snacks.update', $snack) }}" class="space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Food name</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $snack->name) }}"
                            required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 placeholder-gray-400 transition focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                        >
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 placeholder-gray-400 transition focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                        >{{ old('description', $snack->description) }}</textarea>
                    </div>

                    {{-- Price + Category side by side --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">₹</span>
                                <input
                                    id="price"
                                    type="number"
                                    name="price"
                                    value="{{ old('price', $snack->price) }}"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-4 py-3 transition focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                >
                            </div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                            @php
                                $selectedCategory = old('category', $snack->category);
                            @endphp
                            <select
                                id="category"
                                name="category"
                                required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 transition focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                            >
                                @foreach(['Breakfast', 'Lunch', 'Snacks', 'Drinks', 'Other'] as $category)
                                    <option value="{{ $category }}" {{ $selectedCategory === $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                        <a href="{{ route('admin.snacks.index') }}"
                           class="sm:w-1/3 text-center bg-white text-gray-600 border border-gray-200 py-3 rounded-xl font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="sm:w-2/3 bg-gradient-to-r from-orange-500 to-rose-500 text-white py-3 rounded-xl font-semibold shadow-lg shadow-orange-200 hover:from-orange-600 hover:to-rose-600 active:scale-[0.99] transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400"
                        >
                            Save changes
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>

</html>
