<div id="container-1">
    <div class="flex items-center mb-4 mt-5">
        <div class="flex-shrink-0 ms-4">
            <img src="{{ asset('logo.png') }}" alt="Icon" class="h-10 w-8">
        </div>
        <div class="ml-4 ms-5">
            <p class="text-lg font-semibold text-gray-800">
                Центр Эмоциональной Зрелости им. профессора Табидзе А.А.
                Тест Кеттелла-Табидзе 16PF - 187 Форма А 
            </p>
        </div>
    </div>
    <hr class="mt-2 border-t border-black mb-2">
    <!-- Rows/Spots -->
    <div class="space-y-4 mb-6">
        <!-- Row 1: ID (title above, content below) -->
        <div class="flex flex-col items-start">
            <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.id').': '.$person->id ?? '—'  }}</strong>
        </div>
        <!-- Row 2: Name, Gender, Birthday Date, Education Level, Test Date (all in one row) -->
        <div class="flex flex-wrap items-start justify-between gap-6">
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.name') }}</strong>
                <small class="text-gray-800">{{ trim(($person->name ?? '').' '.($person->last_name ?? '')) ?: '—' }}</small>
            </div>
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.gender') }}</strong>
                <small class="text-gray-800">{{ $person->gender ?? '—' }}</small>
            </div>
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.birthday_date') }}</strong>
                <small class="text-gray-800">{{ $bdDisplay }}</small>
            </div>
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.education_level') }}</strong>
                <small class="text-gray-800">{{ $person->education_level ?? '—' }}</small>
            </div>
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.results.test_date') }}</strong>
                <small class="text-gray-800">{{ $tdDisplay }}</small>
            </div>
        </div>
    </d
    <!-- Row 4: Contact info (Email and Phone) -->
    <div class="mt-6">
        <div class="flex flex-wrap items-start gap-6">
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.auth.email') }}</strong>
                <small class="text-gray-800">{{ $user->email ?? '—' }}</small>
            </div>
            <div class="flex flex-col items-start">
                <strong class="text-xs font-semibold uppercase underline">{{ __('doc.profile.phone') }}</strong>
                <small class="text-gray-800">{{ $person->phone ?? '—' }}</small>
            </div>
        </div>
    </div>
    <hr class="mt-2 border-t border-black">
    <div class="text-center mt-3">
        <p>Личностный профиль по Табидзе А.А.</p>
    </div>
    <!-- Row 5: Table (6 columns; columns 3 and 4 merged) -->
    <div class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                <colgroup>
                    <col style="width:16.66%">
                    <col style="width:5%">
                    <col style="width:5%">
                    <col style="width:16.66%">
                    <col style="width:30%">
                    <col style="width:16.66%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-2 py-1 text-center" colspan="6">ЭМОЦИОНАЛЬНЫЕ КАЧЕСТВА</th>
                    </tr>
                    <tr>
                        <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title1') }}</th>
                        <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title2') }}</th>
                        <th colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title3') }}</th>
                        <th class="border border-gray-200 px-2 py-1 text-center">
                            <div class="grid grid-cols-11 gap-0">
                                @foreach (range(-5, 5) as $val)
                                    <div class="text-xs px-1 py-0.5 border border-gray-200">{{ $val }}</div>
                                @endforeach
                            </div>
                        </th>
                        <th class="border border-gray-200 px-2 py-1 text-center">{{ __('doc.results.table_title5') }}</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorC')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorC_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Эмоц. неустойчивость'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorC_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        // central cell always gray
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Эмоц. устойчивость'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorL')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorL_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Подозрительность'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorL_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Доброжелательность'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorO')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorO_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Тревожность'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorO_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Спокойствие'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('doc.results.factorQ4')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorQ4_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Напряженность'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorQ4_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Расслабленность'}}</td>
                    </tr>
                </tbody>
            </table>
        </d
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                <colgroup>
                    <col style="width:16.66%">
                    <col style="width:5%">
                    <col style="width:5%">
                    <col style="width:16.66%">
                    <col style="width:30%">
                    <col style="width:16.66%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-2 py-1 text-center" colspan="6">ВОЛЕВЫЕ КАЧЕСТВА</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор Q3</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorQ3_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Низкий самоконтроль</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorQ3_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        // central cell always gray
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Высокий самоконтроль</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор E</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorE_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Подчиненность</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorE_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Властность</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор G</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorG_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Непостоянство</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorG_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Ответственность</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор H</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorH_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Робость</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorH_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Смелость</td>
                    </tr>
                </tbody>
            </table>
        </d
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                <colgroup>
                    <col style="width:16.66%">
                    <col style="width:5%">
                    <col style="width:5%">
                    <col style="width:16.66%">
                    <col style="width:30%">
                    <col style="width:16.66%">
                </colgroup>
                <thead> 
                    <tr>
                        <th class="border border-gray-200 px-2 py-1 text-center" colspan="6">КОММУНИКАТИВНЫЕ КАЧЕСТВА</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор A</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorA_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Отчужденность</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorA_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        // central cell always gray
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Общительность</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор F</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorF_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">Пессимизм</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorF_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">Оптимизм</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">Фактор I</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorI_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Жесткость'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorI_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Мягкосердечие'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('Фактор Q2')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorQ2_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Зависимость от группы'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorQ2_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Самостоятельность'}}</td>
                    </tr>
                </tbody>
            </table>
        </d
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                <colgroup>
                    <col style="width:16.66%">
                    <col style="width:5%">
                    <col style="width:5%">
                    <col style="width:16.66%">
                    <col style="width:30%">
                    <col style="width:16.66%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="border border-gray-200 px-2 py-1 text-center" colspan="6">ИНТЕЛЛЕКТУАЛЬНЫЕ КАЧЕСТВА</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('Фактор B')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorB_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Низкий интеллект'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorB_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        // central cell always gray
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Высокий интеллект'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('Фактор M')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorM_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Практичность'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorM_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Мечтательность'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('Фактор N')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorN_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Прямолинейность'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorN_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Дипломатичность'}}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{__('Фактор Q1')}}</td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{$userResults->factorQ1_sten}}</td>
                        <td colspan="2" class="border border-gray-200 px-2 py-1 text-center">{{'Консерватизм'}}</td>
                        <td class="border border-gray-200 px-3 py-2">
                            @php $v = (int)($userResults->factorQ1_sten ?? 0); @endphp
                            <div class="grid grid-cols-11 gap-0">
                                @foreach(range(-5,5) as $idx)
                                    @php
                                        if ($idx === 0) {
                                            $cellClass = 'bg-gray-400';
                                        } else {
                                            $cellClass = 'bg-white';
                                            if ($v > 0) {
                                                if ($idx > 0 && $idx <= $v) $cellClass = 'bg-green-500';
                                            } elseif ($v < 0) {
                                                if ($idx < 0 && abs($idx) <= abs($v)) $cellClass = 'bg-red-500';
                                            }
                                        }
                                    @endphp
                                    <div class="h-3 border border-gray-200 {{ $cellClass }}"></div>
                                @endforeach
                            </div>
                        </td>
                        <td class="border border-gray-200 px-2 py-1 text-center">{{'Гибкость'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>