<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Tests') }}
        </h2>
    </x-slot>

    @if(request()->boolean('timeout'))
        <div style="max-width: 80rem; margin: 1.5rem auto 0; padding-left: 1.5rem; padding-right: 2rem;">
            <div id="timeout-alert" style="border-radius: 0.375rem; background-color: #FEF3C7; border: 1px solid #FDE68A; padding: 1rem; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); transition: opacity .6s ease;">
                <div style="display: flex;">
                    <div style="flex-shrink: 0; color: #F59E42;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem;" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.518 11.598c.75 1.336-.213 3.003-1.742 3.003H3.48c-1.53 0-2.492-1.667-1.743-3.003L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a.75.75 0 01-.75-.75V8a.75.75 0 011.5 0v2.25A.75.75 0 0110 11z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div style="margin-left: 0.75rem;">
                        <h3 style="font-size: 0.875rem; font-weight: 600; color: #92400E;">Time is up</h3>
                        <div style="margin-top: 0.25rem; font-size: 0.875rem; color: #B45309;">
                            The available time to answer the questionnaire has ended. Your answers were not submitted.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('timeout-alert');
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(() => { el.remove(); }, 700);
                }
            }, 10000);
        </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($tests as $test)
                <a href="{{ route('questionnaire.index', $test->id) }}" class="block group mb-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 group-hover:border-indigo-400 transition">
                        <div class="p-6 text-gray-900 flex justify-between items-center">
                            <div class="flex flex-col">
                                <span class="font-semibold text-lg group-hover:text-indigo-600">{{ $test->name }}</span>
                                <span class="text-sm text-gray-500 line-clamp-1">{{ $test->description }}</span>
                            </div>
                            @php
                                $totalQuestions = $test->questions()->count();
                                $answered = 0; // placeholder until answer tracking implemented
                            @endphp
                            <span class="ml-4 text-sm text-gray-500">{{ $answered }}/{{ $totalQuestions }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-dashed border-gray-300">
                    <div class="p-6 text-gray-600 text-center text-sm">
                        {{ __('No pending tests. Great job!') }}
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
