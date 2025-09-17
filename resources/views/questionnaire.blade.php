<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questionnaire') }}
        </h2>
    </x-slot>

    <div style="max-width: 80rem; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem; margin-top: 1.5rem;">
        <div style="background: rgba(255,255,255,0.8); backdrop-filter: blur(4px); border: 1px solid #e5e7eb; border-radius: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                <h2 style="font-size: 2rem; font-weight: 700; letter-spacing: -0.01em; color: #111827; display: flex; align-items: center; gap: 0.75rem; margin:0;">
                    <span style="display: inline-flex; height: 2.5rem; width: 2.5rem; align-items: center; justify-content: center; border-radius: 0.5rem; background-color: #4f46e5; color: #fff; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">Q</span>
                    <span>{{ $testName }}</span>
                </h2>
                <div id="countdown-timer" data-minutes="{{ (int) $testDuration }}" style="display:flex; align-items:center; gap:0.75rem; background:#1f2937; color:#f9fafb; padding:0.75rem 1rem; border-radius:0.5rem; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; box-shadow:0 0 0 1px rgba(255,255,255,0.05), 0 2px 4px rgba(0,0,0,0.08);">
                    <span style="font-size:0.75rem; letter-spacing:0.05em; text-transform:uppercase; opacity:0.75; font-weight:600;">{{ __('Time left') }}</span>
                    <span id="countdown-display" style="font-size:1.25rem; font-weight:700; letter-spacing:0.05em;">--:--</span>
                </div>
            </div>
            @isset($testDescription)
                <p style="margin-top: 0.75rem; font-size: 0.875rem; color: #4b5563; line-height: 1.625;">{{ $testDescription }}</p>
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
                                    <label class="flex items-center cursor-pointer" style="user-select:none;">
                                        <input type="radio" name="question{{ $question->id }}" value="{{ $answer->score }}" class="form-radio h-5 w-5 text-indigo-600 answer-radio" data-question-index="{{ $qIndex }}">
                                        <span class="text-gray-700" style="margin-left:14px; display:inline-block;">{{ $answer->answer_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" name="testId" value="{{$testId}}">
            <div class="mt-6 flex items-center justify-center gap-4" id="submit-wrapper" style="display: none;">
                <x-primary-button>
                    {{ __('Score') }}
                </x-primary-button>
                <button type="button" id="reset-questionnaire" 
                    style="
                        padding: 0.5rem 1rem;
                        background-color: #4f46e5;
                        border: none;
                        border-radius: 0.375rem;
                        font-weight: 600;
                        font-size: 0.75rem;
                        text-transform: uppercase;
                        color: #fff;
                        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                        letter-spacing: 0.05em;
                        transition: background 0.15s, box-shadow 0.15s;
                        cursor: pointer;
                    "
                    onmouseover="this.style.backgroundColor='#6366f1'"
                    onmouseout="this.style.backgroundColor='#4f46e5'"
                >
                    {{ __('Reset') }}
                </button>
            </div>
        </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('questionnaire-form');
            const cards = Array.from(document.querySelectorAll('.question-card'));
            const submitWrapper = document.getElementById('submit-wrapper');
            const resetBtn = document.getElementById('reset-questionnaire');
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
                if (nextIndex < total) {
                    const nextCard = cards[nextIndex];
                    if (nextCard.style.display === 'none') {
                        nextCard.style.display = 'block';
                        nextCard.classList.add('animate-fade-in');
                    }
                } else {
                    submitWrapper.style.display = 'flex';
                }
            }

            function disableGroupInputs(groupName) {
                document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => r.disabled = true);
            }

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
                    disableGroupInputs(e.target.name);
                });
            });

            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    resetQuestionnaire();
                });
            }
        });
    </script>
    <style>
        .animate-fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px);} to { opacity:1; transform: translateY(0);} }
    </style>
</x-app-layout>
