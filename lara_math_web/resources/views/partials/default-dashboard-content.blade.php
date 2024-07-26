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
            <li><a href="{{ route('schools.index') }}" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Manage Schools</a></li>
            <li><a href="{{ route('participants.index') }}" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Manage Participants</a></li>
            <li><a href="{{ route('challenges.index') }}" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Create Challenge</a></li>
            <li><a href="{{ route('questions.index') }}" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">Upload Questions</a></li>
            <li><a href="{{ route('reports.index') }}" class="text-blue-300 hover:text-blue-500 hover:underline transition-colors duration-200">View Reports</a></li>

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
