<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(isset($testsWithStatus) && count($testsWithStatus) > 0)
            @foreach($testsWithStatus as $testData)
                @php
                    $test = $testData['test'];
                    $canAccess = $testData['can_access'];
                    $isCompleted = $testData['is_completed'];
                    $progress = $testData['progress'];
                @endphp
                
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg {{ !$canAccess ? 'opacity-50' : '' }}">
                        <div class="p-6 text-gray-900 flex justify-between items-center">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-medium">{{ $test->name }}</h3>
                                    @if($isCompleted)
                                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            {{ __('Completed') }}
                                        </span>
                                    @elseif(!$canAccess)
                                        <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
                                            {{ __('Locked') }}
                                        </span>
                                    @endif
                                </div>
                                @if($test->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $test->description }}</p>
                                @endif
                                @if($test->required_test_id && !$canAccess)
                                    <p class="text-xs text-red-600 mt-1">
                                        {{ __('Complete') }} "{{ $test->requiredTest->name }}" {{ __('first') }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="text-sm text-gray-500">
                                    {{ $progress['answered'] }}/{{ $progress['total'] }}
                                </span>
                            </div>
                            <div class="ml-4">
                                @if($isCompleted)
                                    <a href="{{ route('test.result', $test) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                        {{ __('View Results') }}
                                    </a>
                                @elseif($canAccess)
                                    <a href="{{ route('test.show', $test) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                        @if($progress['answered'] > 0)
                                            {{ __('Continue') }}
                                        @else
                                            {{ __('Start Test') }}
                                        @endif
                                    </a>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-md cursor-not-allowed">
                                        {{ __('Locked') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <p>{{ __('No tests available at the moment.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
