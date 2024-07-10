<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Questions and Answers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Upload Questions and Answers</h3>
                    <form method="POST" action="{{ route('upload.questions') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <label for="questions_file" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Questions File:</label>
                            <input type="file" name="questions_file" id="questions_file" class="mt-1 block w-full" required>
                        </div>
                        <div>
                            <label for="answers_file" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Answers File:</label>
                            <input type="file" name="answers_file" id="answers_file" class="mt-1 block w-full" required>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
