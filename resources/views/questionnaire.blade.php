<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('doc.questionnaire.title') }}
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
                    <span class="text-[0.7rem] tracking-wider uppercase opacity-75 font-semibold">{{ __('doc.questionnaire.time_left') }}</span>
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
                    <input type="radio" name="Answere_{{ $question->id }}" value="{{ $answer->id }}" class="form-radio h-5 w-5 text-indigo-600 answer-radio" data-question-index="{{ $qIndex }}" required>
                                        <span class="text-gray-700 ml-3 inline-block">{{ $answer->answer_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($qIndex < ($countQuestions - 1))
                                <div class="mt-6 flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-2">
{{--===========================================================================================================================================================================================================================================--}}
                                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md font-semibold text-xs uppercase shadow hover:bg-gray-300 transition-colors duration-150 random-button" data-question-index="{{ $qIndex }}">
                                            {{ __('doc.questionnaire.random') }}
                                        </button>
{{--===========================================================================================================================================================================================================================================--}}
                                        <button type="button" class="px-4 py-2 bg-indigo-600 rounded-md font-semibold text-xs uppercase text-white shadow hover:bg-indigo-700 transition-colors duration-150 next-button" data-question-index="{{ $qIndex }}">
                                            {{ __('doc.questionnaire.next') }}
                                        </button>
                                    </div>
                                    <div class="hidden text-sm text-red-600 next-alert" data-question-index="{{ $qIndex }}">
                                        {{ __('doc.questionnaire.select_to_continue') }}
                                    </div>
                                </div>
                            @else
                                <div class="mt-6 flex justify-end">
                                    <x-primary-button>
                                        {{ __('doc.questionnaire.score') }}
                                    </x-primary-button>
                                </div>
                                <div class="mt-2 text-sm text-red-600 submit-alert hidden">
                                    {{ __('doc.questionnaire.select_to_continue') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
        </div>
    </div>

    <div id="loader" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center z-50" style="display: none;">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            <p class="mt-4 text-white font-semibold">{{ __('doc.questionnaire.reading_answers') }}</p>
            <small class="mt-4 text-white font-semibold">{{ __('doc.questionnaire.please_wait') }}</small>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('questionnaire-form');
            const cards = Array.from(document.querySelectorAll('.question-card'));
            const resetBtn = document.getElementById('reset-questionnaire');
            const loader = document.getElementById('loader');
            const total = cards.length;

            // Countdown
            const timerEl = document.getElementById('countdown-timer');
            if (timerEl) {
                const displayEl = document.getElementById('countdown-display');
                const minutes = parseInt(timerEl.getAttribute('data-minutes'), 10);
                const redirectUrl = "{{ route('dashboard.index', [], false) }}?timeout=1";
                const storageKey = 'questionnaire_endTime_{{ $testId }}';

                function format(t) {
                    const m = Math.floor(t / 60).toString().padStart(2,'0');
                    const s = (t % 60).toString().padStart(2,'0');
                    return `${m}:${s}`;
                }

                if (!isNaN(minutes) && minutes > 0) {
                    let endTs = parseInt(localStorage.getItem(storageKey), 10);
                    if (!Number.isFinite(endTs)) {
                        endTs = Date.now() + minutes * 60 * 1000; // ms
                        localStorage.setItem(storageKey, String(endTs));
                    }

                    function tick() {
                        const remaining = Math.max(0, Math.floor((endTs - Date.now()) / 1000));
                        displayEl.textContent = format(remaining);
                        if (remaining <= 0) {
                            localStorage.removeItem(storageKey);
                            window.location.href = redirectUrl;
                            return false; // stop
                        }
                        return true;
                    }

                    // initial paint
                    if (!tick()) { /* already timed out */ }
                    else {
                        const interval = setInterval(() => {
                            if (!tick()) clearInterval(interval);
                        }, 1000);
                    }
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
                        // Last card already has the submit button in place
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

            // Next buttons navigation: advance only if current question has a selected answer
            document.querySelectorAll('.next-button').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const qIdx = parseInt(e.currentTarget.getAttribute('data-question-index'), 10);
                    const currentCard = cards[qIdx];
                    if (!currentCard) return;
                    const hasSelection = !!currentCard.querySelector('input.answer-radio:checked');
                    const alertEl = currentCard.querySelector('.next-alert[data-question-index="' + qIdx + '"]');
                    if (!hasSelection) {
                        if (alertEl) alertEl.classList.remove('hidden');
                        return;
                    }
                    if (alertEl) alertEl.classList.add('hidden');
                    showNext(qIdx);
                });
            });
//================================================================================================================================
            // Random buttons: pick a random option for the current question
            document.querySelectorAll('.random-button').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const qIdx = parseInt(e.currentTarget.getAttribute('data-question-index'), 10);
                    const currentCard = cards[qIdx];
                    if (!currentCard) return;
                    const radios = Array.from(currentCard.querySelectorAll('input.answer-radio'));
                    if (!radios.length) return;
                    // Clear previous selection in this group first
                    radios.forEach(r => { r.checked = false; });
                    const pick = Math.floor(Math.random() * radios.length);
                    radios[pick].checked = true;
                    // Hide any alert since we now have a selection
                    const alertEl = currentCard.querySelector('.next-alert[data-question-index="' + qIdx + '"]');
                    if (alertEl) alertEl.classList.add('hidden');
                    // Also perform the Next behavior
                    showNext(qIdx);
                });
            });
//================================================================================================================================
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    resetQuestionnaire();
                });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                // clear countdown persistence on successful submit
                // Ensure last question is answered
                const lastCard = cards[cards.length - 1];
                const lastHasSelection = !!lastCard?.querySelector('input.answer-radio:checked');
                const submitAlert = lastCard?.querySelector('.submit-alert');
                if (!lastHasSelection) {
                    if (submitAlert) submitAlert.classList.remove('hidden');
                    lastCard?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                } else {
                    if (submitAlert) submitAlert.classList.add('hidden');
                }

                try { localStorage.removeItem('questionnaire_endTime_{{ $testId }}'); } catch (_) {}
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
