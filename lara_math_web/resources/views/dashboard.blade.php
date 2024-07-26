    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-3xl text-slate-800 leading-tight">
                {{ __('MathTrek') }}
            </h2>
        </x-slot>

        <div class="relative py-12 bg-mauve-100 min-h-screen flex items-center justify-center">
        <!-- Background Image -->
        <div class="absolute inset-0 flex items-center justify-center">
                <img src="/images/bg4.png" alt="Background Image" class="w-full h-full object-cover">
            </div>

            <div class="relative max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-cream-100 bg-opacity-30 backdrop-blur-lg overflow-hidden shadow-2xl sm:rounded-2xl">
                    <div class="p-6 text-slate-800">
                        @yield('content', view('partials.default-dashboard-content'))
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
