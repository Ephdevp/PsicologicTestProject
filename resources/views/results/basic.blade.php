<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $test->name . ' (' . $test->category . ')' }} - {{ __('doc.results.results_title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Container 1: Only Next -->
            <div id="container-1" class="bg-white border border-gray-200 rounded-lg shadow p-6">

                <!-- Rows/Spots -->
                <div class="space-y-4 mb-6">
                    <!-- Row 1: ID (title above, content below) -->
                    <div class="flex flex-col items-start">
                        <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.id') }}</strong>
                        <small class="text-gray-800">{{ $person->id ?? '—' }}</small>
                    </div>
                    <!-- Row 2: Name (title above, content below) -->
                    <div class="flex flex-col items-start">
                        <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.name') }}</strong>
                        <small class="text-gray-800">{{ trim(($person->name ?? '').' '.($person->last_name ?? '')) ?: '—' }}</small>
                    </div>
                    <!-- Row 3: Four spots (title above, content below) -->
                    @php
                        $bdDisplay = isset($person->birthdate) && $person->birthdate
                            ? ($person->birthdate instanceof \Illuminate\Support\Carbon
                                ? $person->birthdate->format('d.m.Y')
                                : \Carbon\Carbon::parse($person->birthdate)->format('d.m.Y'))
                            : '—';
                        $tdDisplay = isset($pivotTest->pivot->completed_at) ? ($pivotTest->pivot->completed_at instanceof \Illuminate\Support\Carbon
                                ? $pivotTest->pivot->completed_at->format('d.m.Y')
                                : \Carbon\Carbon::parse($pivotTest->pivot->completed_at)->format('d.m.Y'))
                            : '—';
                    @endphp
                    <div class="flex flex-wrap items-start justify-between gap-6">
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.gender') }}</strong>
                            <small class="text-gray-800">{{ $person->gender ?? '—' }}</small>
                        </div>
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.birthday_date') }}</strong>
                            <small class="text-gray-800">{{ $bdDisplay }}</small>
                        </div>
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.education_level') }}</strong>
                            <small class="text-gray-800">{{ $person->education_level ?? '—' }}</small>
                        </div>
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.results.test_date') }}</strong>
                            <small class="text-gray-800">{{ $tdDisplay }}</small>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Contact info (Email and Phone) -->
                <div class="mt-6">
                    <div class="flex flex-wrap items-start justify-between gap-6">
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.auth.email') }}</strong>
                            <small class="text-gray-800">{{ $user->email ?? '—' }}</small>
                        </div>
                        <div class="flex flex-col items-start">
                            <strong class="text-xs font-semibold uppercase text-gray-500">{{ __('doc.profile.phone') }}</strong>
                            <small class="text-gray-800">{{ $person->phone ?? '—' }}</small>
                        </div>
                    </div>
                </div>

                <!-- Row 5: Table (6 columns; columns 3 and 4 merged) -->
                <div class="mt-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                            <thead>
                                <tr>
                                    <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title1') }}</th>
                                    <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title2') }}</th>
                                    <th colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title3') }}</th>
                                    <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title4') }}</th>
                                    <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title5') }}</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorC')}}</td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorC_sten}}</td>
                                    <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Эмоц. неустойчивость'}}</td>
                                    <td class="border border-gray-200 px-3 py-2">
                                        @php $v = (int)($userResults->factorC_sten ?? 0); $max=5; $pct = min(100, max(0, (abs($v)/$max)*100)); @endphp
                                        <div class="relative h-2 bg-gray-100 rounded">
                                            <div class="absolute inset-y-0 left-1/2 w-px bg-gray-400"></div>
                                            @if($v > 0)
                                                <div class="absolute inset-y-0 left-1/2 bg-green-500" style="width: {{ $pct }}%"></div>
                                            @elseif($v < 0)
                                                <div class="absolute inset-y-0 right-1/2 bg-red-500" style="width: {{ $pct }}%"></div>
                                            @else
                                                <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-2 bg-gray-400"></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{'Эмоц. устойчивость'}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorL')}}</td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorL_sten}}</td>
                                    <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Подозрительность'}}</td>
                                    <td class="border border-gray-200 px-3 py-2">
                                        @php $v = (int)($userResults->factorL_sten ?? 0); $max=5; $pct = min(100, max(0, (abs($v)/$max)*100)); @endphp
                                        <div class="relative h-2 bg-gray-100 rounded">
                                            <div class="absolute inset-y-0 left-1/2 w-px bg-gray-400"></div>
                                            @if($v > 0)
                                                <div class="absolute inset-y-0 left-1/2 bg-green-500" style="width: {{ $pct }}%"></div>
                                            @elseif($v < 0)
                                                <div class="absolute inset-y-0 right-1/2 bg-red-500" style="width: {{ $pct }}%"></div>
                                            @else
                                                <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-2 bg-gray-400"></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{'Доброжелательность'}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorO')}}</td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorO_sten}}</td>
                                    <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Тревожность'}}</td>
                                    <td class="border border-gray-200 px-3 py-2">
                                        @php $v = (int)($userResults->factorO_sten ?? 0); $max=5; $pct = min(100, max(0, (abs($v)/$max)*100)); @endphp
                                        <div class="relative h-2 bg-gray-100 rounded">
                                            <div class="absolute inset-y-0 left-1/2 w-px bg-gray-400"></div>
                                            @if($v > 0)
                                                <div class="absolute inset-y-0 left-1/2 bg-green-500" style="width: {{ $pct }}%"></div>
                                            @elseif($v < 0)
                                                <div class="absolute inset-y-0 right-1/2 bg-red-500" style="width: {{ $pct }}%"></div>
                                            @else
                                                <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-2 bg-gray-400"></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{'Спокойствие'}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorQ4')}}</td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorQ4_sten}}</td>
                                    <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Напряженность'}}</td>
                                    <td class="border border-gray-200 px-3 py-2">
                                        @php $v = (int)($userResults->factorQ4_sten ?? 0); $max=5; $pct = min(100, max(0, (abs($v)/$max)*100)); @endphp
                                        <div class="relative h-2 bg-gray-100 rounded">
                                            <div class="absolute inset-y-0 left-1/2 w-px bg-gray-400"></div>
                                            @if($v > 0)
                                                <div class="absolute inset-y-0 left-1/2 bg-green-500" style="width: {{ $pct }}%"></div>
                                            @elseif($v < 0)
                                                <div class="absolute inset-y-0 right-1/2 bg-red-500" style="width: {{ $pct }}%"></div>
                                            @else
                                                <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-2 bg-gray-400"></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border border-gray-200 px-2 py-1 text-center">{{'Расслабленность'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex gap-2 justify-center mt-3">
                    <button id="next-1" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">
                        {{ __('doc.common.next') }}
                    </button>
                </div>
            </div>

            <!-- Container 2: Next + Back -->
            <div id="container-2" class="bg-white border border-gray-200 rounded-lg shadow p-6 hidden">
                <div class="space-y-6 mb-6">
                    <!-- Table 1 -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-indigo-600 text-white">{{__('doc.results.factorC').' = '.$userResults->factorC_sten.' '.$interpretations['C']['title']}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ПСИХОЛОГИЯ</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ЗДОРОВЬЕ</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['C']['psychology_text']}}</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['C']['health_text']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table 2 -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-indigo-600 text-white">{{__('doc.results.factorL').' = '.$userResults->factorL_sten.' '.$interpretations['L']['title']}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ПСИХОЛОГИЯ</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ЗДОРОВЬЕ</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['L']['psychology_text']}}</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['L']['health_text']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table 3 -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-indigo-600 text-white">{{__('doc.results.factorO').' = '.$userResults->factorO_sten.' '.$interpretations['O']['title']}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ПСИХОЛОГИЯ</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ЗДОРОВЬЕ</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['O']['psychology_text']}}</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['O']['health_text']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table 4 -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-indigo-600 text-white">{{__('doc.results.factorQ4').' = '.$userResults->factorQ4_sten.' '.$interpretations['Q4']['title']}}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ПСИХОЛОГИЯ</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">ЗДОРОВЬЕ</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['Q4']['psychology_text']}}</td>
                                    <td class="border border-gray-200 px-2 py-2 text-center">{{$interpretations['Q4']['health_text']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <!-- Title & Subtitle zones -->
                <div class="mb-6 text-center">
                    <div id="c3-title" class="text-xl font-bold text-gray-900">РЕЗУЛЬТАТ:</div>
                    <div id="c3-subtitle" class="text-sm text-gray-600 mt-1">СТЕПЕНЬ  ЭМОЦИОНАЛЬНОЙ  ЗРЕЛОСТИ  EZ:</div>
                    <div id="c3-subtitle" class="text-sm text-gray-600 mt-1">EZ = C + L + O + Q4 = {{$userResults->factorC_sten.' + '.$userResults->factorL_sten.' + '.$userResults->factorO_sten.' + '.$userResults->factorQ4_sten.' = '.$EZ}}</div>
                </div>
                <!-- Centered 1-column, 2-rows table under info -->
                @php
                    $zoneLabel = '';
                    $row2Bg = '';
                    $row2Text = '';
                    $ezVal = (int)($EZ ?? 0);
                    if ($ezVal >= -20 && $ezVal <= 0) {
                        $zoneLabel = 'Красная зона';
                        $row2Bg = 'bg-red-500';
                        $row2Text = 'text-white';
                    } elseif ($ezVal >= 1 && $ezVal <= 4) {
                        $zoneLabel = 'Желтая зона';
                        $row2Bg = 'bg-yellow-300';
                        $row2Text = 'text-yellow-900';
                    } elseif ($ezVal >= 5 && $ezVal <= 9) {
                        $zoneLabel = 'Салатовая зона';
                        $row2Bg = 'bg-lime-300';
                        $row2Text = 'text-gray-900';
                    } elseif ($ezVal >= 10 && $ezVal <= 20) {
                        $zoneLabel = 'Зеленая зона';
                        $row2Bg = 'bg-green-600';
                        $row2Text = 'text-white';
                    }
                @endphp
                <div class="mb-6 overflow-x-auto">
                    <table class="mx-auto border border-gray-200 text-sm rounded">
                        <tbody>
                            <tr>
                                <td class="px-3 py-2 border border-gray-200 text-center">{{ $zoneLabel }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 border border-gray-200 text-center {{ $row2Bg }} {{ $row2Text }}"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if(($EZ ?? 0) < 2)
                <div class="mb-6 text-sm text-gray-800 whitespace-pre-line text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2 h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75c-1.148-.718-2.541-1.125-4-1.125-1.993 0-3.928.773-5.5 2.164v10.089c1.572-1.391 3.507-2.164 5.5-2.164 1.46 0 2.852.407 4 1.125m0-10.089c1.148-.718 2.541-1.125 4-1.125 1.993 0 3.928.773 5.5 2.164v10.089c-1.572-1.391-3.507-2.164-5.5-2.164-1.46 0-2.852.407-4 1.125" />
                    </svg>
                    РЕКОМЕНДАЦИИ:
                    При степени Эмоциональной зрелости EZ от -20 до +9
                    Пройти курс «Повышение стрессоустойчивости и эмоциональной зрелости»  
                    для формирования новых психо-эмоциональных качеств:
                    - внутренней расслабленности,
                    - внутреннего спокойствия, 
                    - доброжелательности
                    - эмоциональной устойчивости
                    и для снижения психо-соматических проявлений и 
                    повышения физического и эмоционального благополучия.
                                    
                    Если Вы психолог, то курс для Вас
                    “Стрессоустойчивость и формула счастья для психологов”
                                    
                    <strong class="text-indigo-600">Все пункты, представленные в разделе «Здоровье», требуют уточнения и консультации врача.
                    При значениях EZ (от +10 до +20)
                    Для получения Аттестата Эмоциональной Зрелости пройдите тест Кеттелла-Табидзе (вариант В).</strong>
                </div>
                @endif
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
