<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{-- $test->name . ' (' . $test->category . ')' --}} - {{ __('doc.results.results_title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Container 1: Only Next -->
            <div id="container-1" class="bg-white border border-gray-200 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4 text-center">{{ __('doc.results.container_1_title') }}</h3>

                <!-- Rows/Spots -->
                <div class="space-y-4 mb-6">
                    <!-- Row 1: ID (start) -->
                    <div class="flex items-center justify-start">
                        <span class="font-medium w-40">ID:</span>
                        <span id="person-id" class="text-gray-700">—</span>
                    </div>
                    <!-- Row 2: Name (start) -->
                    <div class="flex items-center justify-start">
                        <span class="font-medium w-40">Name:</span>
                        <span id="person-name" class="text-gray-700">—</span>
                    </div>
                    <!-- Row 3: Multiple spots with justify-between -->
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <span class="font-medium">Gender:</span>
                            <span id="person-gender" class="ml-2 text-gray-700">—</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">Birthday date:</span>
                            <span id="person-birthdate" class="ml-2 text-gray-700">—</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">Education level:</span>
                            <span id="person-education" class="ml-2 text-gray-700">—</span>
                        </div>
                        <div class="flex items-center">
                            <span class="font-medium">Test date:</span>
                            <span id="test-date" class="ml-2 text-gray-700">—</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 justify-center">
                    <button id="next-1" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                        {{ __('doc.common.next') }}
                    </button>
                </div>
            </div>

            <!-- Container 2: Next + Back -->
            <div id="container-2" class="bg-white border border-gray-200 rounded-lg shadow p-6 hidden">
                <h3 class="text-lg font-semibold mb-4 text-center">{{ __('doc.results.container_2_title') }}</h3>
                <div class="flex gap-2 justify-center">
                    <button id="next-2" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                        {{ __('doc.common.next') }}
                    </button>
                    <button id="back-2" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                        {{ __('doc.common.back') }}
                    </button>
                </div>
            </div>

            <!-- Container 3: Only Back -->
            <div id="container-3" class="bg-white border border-gray-200 rounded-lg shadow p-6 hidden">
                <h3 class="text-lg font-semibold mb-4 text-center">{{ __('doc.results.container_3_title') }}</h3>
                <div class="flex gap-2 justify-center">
                    <button id="back-3" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-semibold hover:bg-gray-300">
                        {{ __('doc.common.back') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const c1 = document.getElementById('container-1');
            const c2 = document.getElementById('container-2');
            const c3 = document.getElementById('container-3');

            const showOnly = (el) => {
                [c1, c2, c3].forEach(c => c.classList.add('hidden'));
                el.classList.remove('hidden');
            };

            // Initial state: only container 1 visible
            showOnly(c1);

            // Wire buttons
            document.getElementById('next-1')?.addEventListener('click', () => showOnly(c2));
            document.getElementById('next-2')?.addEventListener('click', () => showOnly(c3));
            document.getElementById('back-2')?.addEventListener('click', () => showOnly(c1));
            document.getElementById('back-3')?.addEventListener('click', () => showOnly(c2));
        });
    </script>
</x-app-layout>
