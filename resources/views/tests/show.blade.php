<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $test->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $test->name }}</h3>
                    
                    @if($test->description)
                        <p class="text-gray-700 mb-4">{{ $test->description }}</p>
                    @endif

                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-2">{{ __('Test Information') }}</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>{{ __('Time Limit') }}: {{ $test->time_limit }} {{ __('minutes') }}</li>
                            <li>{{ __('Total Questions') }}: {{ $test->questions()->count() }}</li>
                            @if($test->requiredTest)
                                <li>{{ __('Prerequisite') }}: {{ $test->requiredTest->name }}</li>
                            @endif
                        </ul>
                    </div>

                    @if($activeSession)
                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <h4 class="font-medium text-yellow-800 mb-2">{{ __('Active Session Found') }}</h4>
                            <p class="text-sm text-yellow-700 mb-3">
                                {{ __('You have an active test session. You can continue where you left off.') }}
                            </p>
                            <p class="text-sm text-yellow-700 mb-3">
                                {{ __('Session expires at') }}: {{ $activeSession->expires_at->format('H:i:s') }}
                            </p>
                            <div class="flex space-x-3">
                                <a href="{{ route('test-session.take', $activeSession->session_token) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700">
                                    {{ __('Continue Test') }}
                                </a>
                                <form method="POST" action="{{ route('test.start', $test) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700"
                                            onclick="return confirm('{{ __('This will abandon your current session and start a new one. Are you sure?') }}')">
                                        {{ __('Start New Session') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <h4 class="font-medium text-blue-800 mb-2">{{ __('Ready to Start?') }}</h4>
                            <p class="text-sm text-blue-700 mb-3">
                                {{ __('Once you start the test, you will have') }} {{ $test->time_limit }} {{ __('minutes to complete it.') }}
                                {{ __('Make sure you have enough time and a stable internet connection.') }}
                            </p>
                        </div>

                        <div class="flex space-x-3">
                            <form method="POST" action="{{ route('test.start', $test) }}">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
                                    {{ __('Start Test') }}
                                </button>
                            </form>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center px-6 py-3 bg-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-400">
                                {{ __('Back to Dashboard') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>