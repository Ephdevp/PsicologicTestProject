<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $session->test->name }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">
                    {{ __('Progress') }}: {{ $session->getCompletionPercentage() }}%
                </span>
                <div id="timer" class="text-sm font-medium text-red-600"></div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @foreach($questions as $index => $question)
                <div class="mb-6">
                    <div class="bg-white border border-gray-300 shadow-md rounded-lg">
                        <div class="p-6">
                            <form method="POST" action="{{ route('test-session.answer', $session->session_token) }}">
                                @csrf
                                <input type="hidden" name="question_id" value="{{ $question->id }}">
                                
                                <div class="flex items-start mb-4">
                                    <span class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-800 rounded-full flex items-center justify-center text-sm font-medium mr-4">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-lg font-medium text-gray-800">
                                        {{ $question->question_text }}
                                    </p>
                                </div>

                                <div class="ml-12 space-y-3">
                                    @foreach($question->answers as $answer)
                                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                            <input type="radio" 
                                                   name="answer_id" 
                                                   value="{{ $answer->id }}" 
                                                   class="form-radio h-5 w-5 text-indigo-600"
                                                   {{ in_array($question->id, $answeredQuestions) ? 'disabled' : '' }}
                                                   onchange="this.form.submit()">
                                            <span class="text-gray-700">{{ $answer->answer_text }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                @if(in_array($question->id, $answeredQuestions))
                                    <div class="ml-12 mt-3">
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            ✓ {{ __('Answered') }}
                                        </span>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @if($session->isComplete())
                <div class="text-center mt-8">
                    <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-4">
                        <p class="text-green-800 font-medium">
                            {{ __('All questions have been answered! Your test will be submitted automatically.') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Timer functionality
        const expiresAt = new Date('{{ $session->expires_at->toISOString() }}');
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const now = new Date();
            const timeLeft = expiresAt - now;

            if (timeLeft <= 0) {
                timerElement.textContent = '{{ __("Time Expired!") }}';
                timerElement.classList.add('text-red-800', 'font-bold');
                // Redirect to dashboard after a short delay
                setTimeout(() => {
                    window.location.href = '{{ route("dashboard") }}';
                }, 3000);
                return;
            }

            const minutes = Math.floor(timeLeft / 60000);
            const seconds = Math.floor((timeLeft % 60000) / 1000);
            
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')} {{ __('remaining') }}`;
            
            // Change color when less than 5 minutes left
            if (minutes < 5) {
                timerElement.classList.add('text-red-800', 'font-bold');
            }
        }

        // Update timer every second
        updateTimer();
        setInterval(updateTimer, 1000);

        // Warn user before leaving the page
        window.addEventListener('beforeunload', function (e) {
            e.preventDefault();
            e.returnValue = '{{ __("Are you sure you want to leave? Your progress will be saved but the timer will continue.") }}';
        });
    </script>
</x-app-layout>