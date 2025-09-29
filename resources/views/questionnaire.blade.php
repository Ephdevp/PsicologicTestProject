<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questionnaire') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 mt-6">
        <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 flex items-center gap-3 m-0">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600 text-white font-semibold shadow-sm">Q</span>
                    <span>{{ $testName }}</span>
                </h2>
                <div id="countdown-timer" data-minutes="{{ (int) $testDuration }}" class="flex items-center gap-3 bg-white/100 text-gray-800 px-4 py-3 rounded-lg font-mono shadow ring-1 ring-white/5">
                    <span class="text-[0.7rem] tracking-wider uppercase opacity-75 font-semibold">{{ __('Time left') }}</span>
                    <span id="countdown-display" class="text-xl font-bold tracking-wider">--:--</span>
                </div>
            </div>
            @isset($testDescription)
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">{{ $testDescription }}</p>
            @endisset
        </div>
    </div>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{route('test.questionarieSubmit')}}" method="POST" id="questionnaire-form">
            @csrf
            @foreach ($questions as $qIndex => $question)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4 question-card" data-index="{{ $qIndex }}" style="display: {{ $qIndex === 0 ? 'block' : 'none' }};">
                    <div class="bg-white border border-gray-300 shadow-md rounded-lg">
                        <div class="p-6">
                            <p class="block text-lg font-semibold text-gray-800 mb-4">
                                {{ ($qIndex+1) . '. ' . $question->question_text }}
                            </p>
                            <div class="space-y-3">
                                @foreach($question->answers as $aIndex => $answer)
                                    <label class="flex items-center cursor-pointer select-none">
                                        <input type="radio" name="Answere_{{ $question->id }}" value="{{ $answer->id }}" class="form-radio h-5 w-5 text-indigo-600 answer-radio" data-question-index="{{ $qIndex }}">
                                        <span class="text-gray-700 ml-3 inline-block">{{ $answer->answer_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-6 items-center justify-center gap-4 hidden" id="submit-wrapper">
                <x-primary-button>
                    {{ __('Score') }}
                </x-primary-button>
                {{-- <button type="button" id="reset-questionnaire"
                    class="px-4 py-2 bg-indigo-600 rounded-md font-semibold text-xs uppercase text-white shadow hover:bg-indigo-700 transition-colors duration-150 cursor-pointer"
                >
                    {{ __('Reset') }}
                </button> --}}
            </div>
        </form>
        </div>
    </div>

    <div id="loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center z-50" style="display: none;">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <p class="mt-4 text-white font-semibold">{{ __('Reading answers...') }}</p>
            <small class="mt-4 text-white font-semibold">{{ __('Please wait while we process your answers.') }}</small>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('questionnaire-form');
            const cards = Array.from(document.querySelectorAll('.question-card'));
            const submitWrapper = document.getElementById('submit-wrapper');
            const resetBtn = document.getElementById('reset-questionnaire');
            const loader = document.getElementById('loader');
            const total = cards.length;

            // Countdown
            const timerEl = document.getElementById('countdown-timer');
            if (timerEl) {
                const displayEl = document.getElementById('countdown-display');
                let remaining = parseInt(timerEl.getAttribute('data-minutes'), 10) * 60; // seconds
                const redirectUrl = "{{ route('dashboard.index', [], false) }}?timeout=1";
                if (!isNaN(remaining) && remaining > 0) {
                    function format(t) {
                        const m = Math.floor(t / 60).toString().padStart(2,'0');
                        const s = (t % 60).toString().padStart(2,'0');
                        return `${m}:${s}`;
                    }
                    displayEl.textContent = format(remaining);
                    const interval = setInterval(() => {
                        remaining--;
                        if (remaining <= 0) {
                            displayEl.textContent = '00:00';
                            clearInterval(interval);
                            window.location.href = redirectUrl;
                        } else {
                            displayEl.textContent = format(remaining);
                        }
                    }, 1000);
                }
            }

            function showNext(currentIndex) {
                const nextIndex = currentIndex + 1;
                const currentCard = cards[currentIndex];
                if (currentCard) {
                    currentCard.style.display = 'none';
                }
                if (nextIndex < total) {
                    const nextCard = cards[nextIndex];
                    nextCard.style.display = 'block';
                    nextCard.classList.add('animate-fade-in');
                    nextCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    submitWrapper.style.display = 'flex';
                    submitWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            // (Optional) If you prefer to lock answers, enable this function and call it on change.
            // function disableGroupInputs(groupName) {
            //     document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => r.disabled = true);
            // }

            function enableAllInputs() {
                document.querySelectorAll('.answer-radio').forEach(r => { r.disabled = false; r.checked = false; });
            }

            function resetQuestionnaire() {
                cards.forEach((card, idx) => {
                    card.style.display = idx === 0 ? 'block' : 'none';
                });
                enableAllInputs();
                submitWrapper.style.display = 'none';
                cards[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            document.querySelectorAll('.answer-radio').forEach(radio => {
                radio.addEventListener('change', function (e) {
                    const qIdx = parseInt(e.target.getAttribute('data-question-index'), 10);
                    showNext(qIdx);
                    // disableGroupInputs(e.target.name);
                });
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    resetQuestionnaire();
                });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                loader.style.display = 'flex';

                setTimeout(() => {
                    form.submit();
                }, 1000); // 1 second
            });
        });
    </script>
    <style>
        .animate-fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px);} to { opacity:1; transform: translateY(0);} }
    </style>
</x-app-layout>
