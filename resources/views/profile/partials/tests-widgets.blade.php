@php
    // Hardcoded demo data
    $available = [
        ['title' => 'Anxiety Scale', 'description' => 'Assess current anxiety levels', 'estimated' => '5 min'],
        ['title' => 'Depression Inventory', 'description' => 'Screen for depressive symptoms', 'estimated' => '7 min'],
        ['title' => 'Stress Profile', 'description' => 'Evaluate perceived stress', 'estimated' => '4 min'],
    ];

    $completed = [
        ['title' => 'Personality Trait Test', 'date' => '2025-09-10', 'score' => '85/100'],
        ['title' => 'Cognitive Assessment', 'date' => '2025-09-12', 'score' => '78/100'],
    ];
@endphp

<section>
    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900">{{ __('Your Tests Overview') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('Summary of available and completed tests.') }}</p>
    </header>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="p-5 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-lg shadow flex flex-col">
            <h3 class="text-base font-semibold mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4m0-4a5 5 0 005-5V5a3 3 0 10-6 0v7a5 5 0 005 5" />
                </svg>
                {{ __('Available Tests') }}
            </h3>
            <ul class="space-y-3 text-sm flex-1">
                @foreach($available as $t)
                    <li class="bg-white/10 backdrop-blur-sm rounded px-3 py-2">
                        <p class="font-medium">{{ $t['title'] }}</p>
                        <p class="text-white/80">{{ $t['description'] }}</p>
                        <p class="text-xs text-white/60 mt-1">{{ __('Estimated:') }} {{ $t['estimated'] }}</p>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">
                <button type="button" class="inline-flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-sm font-medium rounded-md transition">
                    {{ __('View all') }}
                </button>
            </div>
        </div>

        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
            <h3 class="text-base font-semibold mb-3 flex items-center gap-2 text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm3.707 6.293l-4 4a1 1 0 01-1.414 0l-2-2 1.414-1.414L9 10.586l3.293-3.293 1.414 1.414z" />
                </svg>
                {{ __('Completed Tests') }}
            </h3>
            <ul class="space-y-3 text-sm flex-1">
                @forelse($completed as $t)
                    <li class="rounded border border-gray-100 px-3 py-2">
                        <p class="font-medium text-gray-900">{{ $t['title'] }}</p>
                        <p class="text-gray-600 text-xs mt-0.5">{{ __('Date:') }} {{ $t['date'] }}</p>
                        <p class="text-gray-600 text-xs">{{ __('Score:') }} {{ $t['score'] }}</p>
                    </li>
                @empty
                    <li class="text-gray-500 italic">{{ __('No tests completed yet.') }}</li>
                @endforelse
            </ul>
            <div class="mt-4">
                <button type="button" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                    {{ __('View history') }}
                </button>
            </div>
        </div>
    </div>
</section>
