<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test Results') }}: {{ $test->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Test Completed Successfully!') }}</h3>
                        <p class="text-gray-600">
                            {{ __('Completed on') }}: {{ $session->completed_at->format('F j, Y \a\t g:i A') }}
                        </p>
                        <p class="text-gray-600">
                            {{ __('Duration') }}: {{ $session->started_at->diffForHumans($session->completed_at, true) }}
                        </p>
                    </div>

                    @if(count($interpretations) > 0)
                        <div class="space-y-6">
                            <h4 class="text-lg font-medium text-gray-900 border-b pb-2">
                                {{ __('Your Results') }}
                            </h4>

                            @foreach($interpretations as $factor => $data)
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h5 class="text-md font-medium text-gray-900 capitalize">
                                            {{ ucfirst($factor) }}
                                        </h5>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-indigo-600">
                                                {{ $data['sten_score'] }}/10
                                            </div>
                                            <div class="text-sm text-gray-500">STEN Score</div>
                                        </div>
                                    </div>

                                    @if($data['interpretation'])
                                        <div class="mb-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                @if($data['sten_score'] >= 8) bg-green-100 text-green-800
                                                @elseif($data['sten_score'] >= 6) bg-yellow-100 text-yellow-800
                                                @elseif($data['sten_score'] >= 4) bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ $data['interpretation']->level_name }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $data['interpretation']->interpretation }}
                                        </p>
                                    @endif

                                    <!-- STEN Scale Visualization -->
                                    <div class="mt-4">
                                        <div class="flex items-center space-x-1">
                                            @for($i = 1; $i <= 10; $i++)
                                                <div class="flex-1 h-6 rounded {{ $i == $data['sten_score'] ? 'bg-indigo-600' : 'bg-gray-200' }} flex items-center justify-center">
                                                    @if($i == $data['sten_score'])
                                                        <span class="text-white text-xs font-bold">{{ $i }}</span>
                                                    @else
                                                        <span class="text-gray-500 text-xs">{{ $i }}</span>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>{{ __('Low') }}</span>
                                            <span>{{ __('Average') }}</span>
                                            <span>{{ __('High') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">{{ __('Results are being processed...') }}</p>
                        </div>
                    @endif

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Important Note') }}</h4>
                            <p class="text-sm text-blue-700">
                                {{ __('These results are based on your responses to this psychological assessment. For a complete understanding of your personality profile, consider consulting with a qualified professional who can provide personalized interpretation and guidance.') }}
                            </p>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
                                {{ __('Back to Dashboard') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>