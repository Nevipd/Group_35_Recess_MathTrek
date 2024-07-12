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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Profile Card -->
                        <div class="bg-blue-100 p-6 rounded-2xl shadow-lg backdrop-blur-md">
                            <div class="flex items-center space-x-4">
                                <img class="h-12 w-12 rounded-full" src="/images/user1.png" alt="Profile Picture">
                                <div>
                                    <h3 class="text-lg font-semibold">Welcome Back,</h3>
                                    <p>{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links Card -->
                        <div class="bg-cream-100 p-6 rounded-2xl shadow-lg backdrop-blur-md">
                            <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Manage Schools</a></li>
                                <li><a href="#" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Upload Questions</a></li>
                                <li><a href="#" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">View Reports</a></li>
                                <li><a href="#" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Settings</a></li>
                            </ul>
                        </div>

                        <!-- Notifications Card -->
                        <div class="bg-green-100 p-6 rounded-2xl shadow-lg backdrop-blur-md">
                            <h3 class="text-lg font-semibold mb-4">Notifications</h3>
                            <p>No new notifications.</p>
                        </div>
                    </div>

                    <!-- Additional Content -->
                    <div class="mt-8 bg-red-100 bg-opacity-90 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
                        <h3 class="text-lg font-semibold mb-4">Recent Activities</h3>
                        <ul class="space-y-2">
                            <li>You uploaded a new set of questions.</li>
                            <li>School data has been updated.</li>
                            <li>Generated new report for Math Challenge 2024.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
