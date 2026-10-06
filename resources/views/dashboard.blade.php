<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center shadow-md">

                <svg
                    class="w-5 h-5 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    />

                </svg>

            </div>


            

        </div>

    </x-slot>


    <div class="py-12 bg-gradient-to-b from-gray-50 to-white min-h-screen">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            {{-- Welcome Banner --}}

            <div
                class="bg-gradient-to-r from-indigo-600 via-blue-600 to-blue-500
                       rounded-3xl shadow-xl shadow-blue-200/50
                       overflow-hidden relative mb-8"
            >

                {{-- Background Pattern --}}

                <div
                    class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"
                >
                </div>


                {{-- Welcome Content --}}

                <div
                    class="relative px-6 sm:px-8 py-8 sm:py-10
                           flex flex-col sm:flex-row
                           sm:items-center sm:justify-between
                           gap-6"
                >


                    {{-- Left Side: User Welcome --}}

                    <div class="flex items-center gap-5">


                        {{-- User Initial --}}

                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16
                                   rounded-2xl bg-white/15 backdrop-blur
                                   flex items-center justify-center
                                   text-xl sm:text-2xl font-bold text-white
                                   flex-shrink-0 border border-white/20"
                        >

                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                        </div>


                        {{-- Welcome Text --}}

                        <div>

                            <h1
                                class="text-2xl sm:text-3xl
                                       font-extrabold text-white
                                       tracking-tight"
                            >

                                Welcome, {{ Auth::user()->name }}!

                            </h1>


                            <p class="text-blue-100 mt-1 text-sm sm:text-base">

                                Welcome to Smart Campus Canteen.

                            </p>

                        </div>

                    </div>


                    {{-- Right Side: Logout Button --}}

                    <div class="relative flex sm:justify-end">

                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center
                                       gap-2
                                       px-5 py-3
                                       rounded-xl
                                       bg-white/15
                                       backdrop-blur
                                       border border-white/30
                                       text-white
                                       font-semibold
                                       text-sm
                                       hover:bg-white/25
                                       hover:border-white/50
                                       transition-all duration-200
                                       shadow-md
                                       w-full sm:w-auto"
                            >

                                {{-- Logout Icon --}}

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 15l3-3m0 0l-3-3m3 3H9"
                                    />

                                </svg>


                                Logout

                            </button>

                        </form>

                    </div>


                </div>

            </div>


            {{-- Quick Actions --}}

            <div
                class="bg-white shadow-sm rounded-2xl
                       border border-gray-100 p-4 sm:p-6"
            >

                <h2
                    class="text-sm font-semibold text-gray-400
                           uppercase tracking-wide mb-4"
                >

                    Quick Actions

                </h2>


                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-5"
                >


                    {{-- Food --}}

                    <a
                        href="{{ route('food.index') }}"
                        class="group relative overflow-hidden
                               bg-gradient-to-br from-blue-500 to-blue-600
                               text-white p-6 rounded-2xl
                               shadow-md shadow-blue-200/60
                               hover:shadow-lg hover:shadow-blue-300/60
                               hover:-translate-y-1
                               transition-all duration-200"
                    >

                        <div
                            class="absolute -right-4 -top-4
                                   w-24 h-24 bg-white/10 rounded-full"
                        >
                        </div>

                        <div
                            class="absolute -right-2 -top-8
                                   w-16 h-16 bg-white/10 rounded-full"
                        >
                        </div>


                        <div class="relative">

                            <div
                                class="w-11 h-11 rounded-xl
                                       bg-white/20
                                       flex items-center justify-center mb-4"
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 8h1a4 4 0 010 8h-1M5 8h13v9a4 4 0 01-4 4H9a4 4 0 01-4-4V8zM5 8L7 2h10l2 6"
                                    />

                                </svg>

                            </div>


                            <h3 class="text-lg font-bold">

                                View Food

                            </h3>


                            <p class="text-sm mt-1 text-blue-100">

                                Browse available food items.

                            </p>


                            <span
                                class="inline-flex items-center gap-1
                                       text-sm font-semibold mt-4
                                       text-white/90
                                       group-hover:gap-2
                                       transition-all"
                            >

                                Browse now

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />

                                </svg>

                            </span>

                        </div>

                    </a>


                    {{-- Cart --}}

                    <a
                        href="{{ route('cart.index') }}"
                        class="group relative overflow-hidden
                               bg-gradient-to-br from-emerald-500 to-green-600
                               text-white p-6 rounded-2xl
                               shadow-md shadow-green-200/60
                               hover:shadow-lg hover:shadow-green-300/60
                               hover:-translate-y-1
                               transition-all duration-200"
                    >

                        <div
                            class="absolute -right-4 -top-4
                                   w-24 h-24 bg-white/10 rounded-full"
                        >
                        </div>

                        <div
                            class="absolute -right-2 -top-8
                                   w-16 h-16 bg-white/10 rounded-full"
                        >
                        </div>


                        <div class="relative">

                            <div
                                class="w-11 h-11 rounded-xl
                                       bg-white/20
                                       flex items-center justify-center mb-4"
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                    />

                                </svg>

                            </div>


                            <h3 class="text-lg font-bold">

                                My Cart

                            </h3>


                            <p class="text-sm mt-1 text-green-100">

                                View items added to cart.

                            </p>


                            <span
                                class="inline-flex items-center gap-1
                                       text-sm font-semibold mt-4
                                       text-white/90
                                       group-hover:gap-2
                                       transition-all"
                            >

                                Go to cart

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />

                                </svg>

                            </span>

                        </div>

                    </a>


                    {{-- Orders --}}

                    <a
                        href="{{ route('orders.index') }}"
                        class="group relative overflow-hidden
                               bg-gradient-to-br from-purple-500 to-purple-600
                               text-white p-6 rounded-2xl
                               shadow-md shadow-purple-200/60
                               hover:shadow-lg hover:shadow-purple-300/60
                               hover:-translate-y-1
                               transition-all duration-200"
                    >

                        <div
                            class="absolute -right-4 -top-4
                                   w-24 h-24 bg-white/10 rounded-full"
                        >
                        </div>

                        <div
                            class="absolute -right-2 -top-8
                                   w-16 h-16 bg-white/10 rounded-full"
                        >
                        </div>


                        <div class="relative">

                            <div
                                class="w-11 h-11 rounded-xl
                                       bg-white/20
                                       flex items-center justify-center mb-4"
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />

                                </svg>

                            </div>


                            <h3 class="text-lg font-bold">

                                My Orders

                            </h3>


                            <p class="text-sm mt-1 text-purple-100">

                                View your previous orders.

                            </p>


                            <span
                                class="inline-flex items-center gap-1
                                       text-sm font-semibold mt-4
                                       text-white/90
                                       group-hover:gap-2
                                       transition-all"
                            >

                                View orders

                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />

                                </svg>

                            </span>

                        </div>

                    </a>


                </div>

            </div>


        </div>

    </div>

</x-app-layout>
