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
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    div {
        font-family: 'Roboto', sans-serif;
        font-size: 21px;
        color: #000000;
    }

    /* Darken all table borders and ensure visible solid lines */
    table, th, td {
        border-color: #374151 !important; /* Tailwind gray-700 */
        border-width: 1px !important;
        border-style: solid !important;
    }

    /* Make header and cell backgrounds neutral to emphasize borders */
    /* Compact styles for the specific table under EZ */
    .compact-table td, .compact-table th {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        padding-left: 6px !important;
        padding-right: 6px !important;
        font-size: 12px !important;
        line-height: 1 !important;
        height: 26px !important;
        vertical-align: middle !important;
    }
    .compact-table .align-middle { vertical-align: middle !important; }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $test->name . ' (' . $test->category . ')' }} - {{ __('doc.results.results_title') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Combined Container: All in One -->
            <div id="container-all" class="bg-white border border-gray-200 rounded-lg shadow p-6">

                <!-- Factor tables: -->
                @include('results._partials.container1')
                <div class="text-center mt-5">
                    <small>Факторы со значениями Ф от -2 до +2 являются слабовыраженными.</small>
                </div>
                <p class="text-center mt-5">Детальная интерпретация (выраженные факторы):</p>
                @php
                    $emotionalItems1 = [
                        'Фактор C ('.$userResults->factorC_sten.'): '.($userResults->factorC_sten <= 0 ? 'эмоциональная неустойчивость, невротизация, истеричность, неуравновешенность.' : 'эмоциональная устойчивость, самообладание, работоспособность'),
                        'Фактор L ('.$userResults->factorL_sten.'): '.($userResults->factorL_sten <= 0 ? 'подозрительность, ревность, эгоцентричность, претензии, чувство недооцененности, завистливость.' : 'доброжелательность, дружелюбность, уживчивость'),
                        'Фактор O ('.$userResults->factorO_sten.'): '.($userResults->factorO_sten <= 0 ? 'тревожность, депрессивность, неуверенность в своих силах' : 'спокойствие, безмятежность, жизнерадостность, уверенность в себе, ощущение безопасности.'),
                        'Фактор Q4 ('.$userResults->factorQ4_sten.'): '.($userResults->factorQ4_sten <= 0 ? 'психическое напряжение, внутреннее напряжение, раздражительность, неумение расслабляться, непреодолимость препятствий, отсутствие концентрации внимания, ошибки в работе.' : 'психическая релаксация, внутренняя расслабленность, успешность в сосредоточенной работе'),
                    ];
                    $emotionalItems2 = [
                        'Фактор Q3 ('.$userResults->factorQ3_sten.'): '.($userResults->factorQ3_sten <= 0 ? ': низкий самоконтроль, импульсивность, неорганизованность, упрямство,  склонность к психопатии, слабая воля.' : 'высокий самоконтроль, организованность, настойчивость, преодоление, '),
                        'Фактор E ('.$userResults->factorE_sten.'): '.($userResults->factorE_sten <= 0 ? 'подчиненность, уступчивость, избегание препятствий, робость, скромность, «ведомый», поиск опоры.' : 'властность, лидерство, независимость, «ведущий».'),
                        'Фактор G ('.$userResults->factorG_sten.'): '.($userResults->factorG_sten <= 0 ? 'непостоянство, небрежность, необязательность.' : 'ответственность, стойкость, упорство, дисциплинированность, общественное выше личного.'),
                        'Фактор H ('.$userResults->factorH_sten.'): '.($userResults->factorH_sten <= 0 ? 'робость, застенчивость, комплекс неполноценности.' : 'смелость, риск, уверенность, склонность к лидерству.'),
                    ];
                    $emotionalItems3 = [
                        'Фактор A ('.$userResults->factorA_sten.'): '.($userResults->factorA_sten <= 0 ? 'отчужденность, замкнутость, погруженность в себя, интроверсия, работа в одиночку, холодноватость.' : 'общительность, организатор, разговорчивость.'),
                        'Фактор F ('.$userResults->factorF_sten.'): '.($userResults->factorF_sten <= 0 ? 'пессимизм, драматизация, усложнения, груз забот.' : 'оптимизм, энергичность, ощущение силы, вера в себя, в удачу, в везение беспечность.'),
                        'Фактор I ('.$userResults->factorI_sten.'): '.($userResults->factorI_sten <= 0 ? 'жесткость, суровость, несентиментальность, черствый в отношениях' : 'мягкосердечие, интуитивность, эмпатия, тонкий вкус, сентиментальность.'),
                        'Фактор Q2 ('.$userResults->factorQ2_sten.'): '.($userResults->factorQ2_sten <= 0 ? 'зависимость от группы, внушаемость, несамостоятельность, потребность в социальном одобрении.' : 'самостоятельность, самодостаточность'),
                    ];
                    $emotionalItems4 = [
                        'Фактор B ('.$userResults->factorB_sten.'): '.($userResults->factorB_sten <= 0 ? 'низкий интеллект, трудности в обучении, конкретное мышление.' : 'высокий интеллект, упорство, настойчивость, абстрактное мышление.'),
                        'Фактор M ('.$userResults->factorM_sten.'): '.($userResults->factorM_sten <= 0 ? 'практичность, реалистичность, приземленность, стереотипность, добросовестность.' : 'мечтательность, идеалистичность'),
                        'Фактор N ('.$userResults->factorN_sten.'): '.($userResults->factorN_sten <= 0 ? 'прямолинейность, склонность к конфликтам, простота, естественность, наивность.' : 'дипломатичность, проницательность, тонкость вкуса, преобладают эстетические интересы. '),
                        'Фактор Q1 ('.$userResults->factorQ1_sten.'): '.($userResults->factorQ1_sten <= 0 ? 'консерватизм, ригидность мышления, боязнь нового, стереотипы, признание авторитетов, высокая чувствительность к неудачам и ошибкам.' : 'гибкость мышления, поиск новых путей решения, умение обобщать и анализировать, самостоятельность в постановке задач и реализации своих идей.'),
                    ];
                @endphp

                <x-factor-interpretation :title="'ЭМОЦИОНАЛЬНЫЕ ФАКТОРЫ:'" :items="$emotionalItems1" />
                <x-factor-interpretation :title="'ВОЛЕВЫЕ КАЧЕСТВА:'" :items="$emotionalItems2" />
                <x-factor-interpretation :title="'КОММУНИКАТИВНЫЕ КАЧЕСТВА:'" :items="$emotionalItems3" />
                <x-factor-interpretation :title="'ИНТЕЛЛЕКТУАЛЬНЫЕ КАЧЕСТВА:'" :items="$emotionalItems4" />
                <!-- Container 2: Next + Back -->
                <div id="container-2">
                    <div class="space-y-6 mb-6">
                        <!-- Table 1 -->
                        <div class="overflow-x-auto mt-3">
                            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-gray-300 text-dark" style="width: 50%;">{{__('doc.results.factorC').' = '.$userResults->factorC_sten.' '.$interpretations['C']['title']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ПСИХОЛОГИЯ</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ЗДОРОВЬЕ</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['C']['psychology_text']}}</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['C']['health_text']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Table 2 -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-gray-300 text-dark" style="width: 50%;">{{__('doc.results.factorL').' = '.$userResults->factorL_sten.' '.$interpretations['L']['title']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ПСИХОЛОГИЯ</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ЗДОРОВЬЕ</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['L']['psychology_text']}}</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['L']['health_text']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Table 3 -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-gray-300 text-dark" style="width: 50%;">{{__('doc.results.factorO').' = '.$userResults->factorO_sten.' '.$interpretations['O']['title']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ПСИХОЛОГИЯ</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ЗДОРОВЬЕ</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['O']['psychology_text']}}</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['O']['health_text']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Table 4 -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed border-collapse border border-gray-200 text-xs">
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="border border-gray-200 px-2 py-2 text-center bg-gray-300 text-dark" style="width: 50%;">{{__('doc.results.factorQ4').' = '.$userResults->factorQ4_sten.' '.$interpretations['Q4']['title']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ПСИХОЛОГИЯ</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">ЗДОРОВЬЕ</td>
                                    </tr>
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['Q4']['psychology_text']}}</td>
                                        <td class="border border-gray-200 px-2 py-2 text-center" style="width: 50%;">{{$interpretations['Q4']['health_text']}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Container 3: Only Back -->
                <div id="container-3">
                    <!-- Title & Subtitle zones -->
                    <div class="mb-6">
                        <div id="c3-title" class="text-xl font-bold text-gray-900">РЕЗУЛЬТАТ:</div>
                        <div id="c3-title" class="text-xl font-bold text-gray-900">СТЕПЕНЬ  ЭМОЦИОНАЛЬНОЙ  ЗРЕЛОСТИ  EZ </div>
                        <div id="c3-subtitle" class="text-sm text-gray-600 mt-1">(суммарный показатель состояния эмоций человека, фундамент его стрессоустойчивости, эмоционального интеллекта, энергетического ресурса, работоспособности, настроения, здоровья):</div>
                    </div>
                    <!-- Centered 1-column, 2-rows table under info -->
                    @php
                        $zoneLabel = '';
                        $row2Bg = '';
                        $row2Text = '';
                        $ezVal = (int)($EZ ?? 0);
                        if ($ezVal >= -20 && $ezVal <= 0) {
                            $zoneLabel = 'Эмоционально зрелый';
                            $row2Bg = 'bg-red-500';
                            $row2Text = 'text-white';
                        } elseif ($ezVal >= 1 && $ezVal <= 4) {
                            $zoneLabel = 'Эмоционально зрелый';
                            $row2Bg = 'bg-yellow-300';
                            $row2Text = 'text-yellow-900';
                        } elseif ($ezVal >= 5 && $ezVal <= 9) {
                            $zoneLabel = 'Эмоционально зрелый';
                            $row2Bg = 'bg-green-500';
                            $row2Text = 'text-gray-900';
                        } elseif ($ezVal >= 10 && $ezVal <= 20) {
                            $zoneLabel = 'Эмоционально зрелый';
                            $row2Bg = 'bg-green-800';
                            $row2Text = 'text-white';
                        }
                        $factorC = $userResults->factorC_sten < 0 ? '('.$userResults->factorC_sten.')' : $userResults->factorC_sten;
                        $factorL = $userResults->factorL_sten < 0 ? '('.$userResults->factorL_sten.')' : $userResults->factorL_sten;
                        $factorO = $userResults->factorO_sten < 0 ? '('.$userResults->factorO_sten.')' : $userResults->factorO_sten;
                        $factorQ4 = $userResults->factorQ4_sten < 0 ? '('.$userResults->factorQ4_sten.')' : $userResults->factorQ4_sten;
                    @endphp
                    <div class="flex items-center justify-center">
                        <div id="c3-subtitle" class="text-lg text-gray-600 font-bold">
                            EZ = C + L + O + Q4 = {{$factorC.' + '.$factorL.' + '.$factorO.' + '.$factorQ4.' = '.$EZ}}
                        </div>
                        <div class="mb-6 overflow-x-auto mt-3 ms-5">
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
                    </div>
                    <div id="c3-title" class="text-xl font-bold text-gray-900">Таблица:</div>
                    <div class="mt-4 overflow-x-auto">
                        <table class="mx-auto border-collapse border border-gray-700 text-sm compact-table" style="border-width:1px;">
                            <tbody>
                                <tr>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">Эмоционально незрелый</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">от</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">-20</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">до</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">0</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">&nbsp;</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center bg-red-500" style="width:12.5%;">&nbsp;</td>
                                    <th class="border border-gray-700 px-2 py-2 text-center" style="width:12.5%;">Красная зона</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-700 px-2 py-2 align-middle text-center" rowspan="3" style="vertical-align:middle;">Texto centrado aquí</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">от</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+1</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">до</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+4</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">низкая степень</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center bg-yellow-300"></td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">Желтая зона</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-700 px-2 py-2 text-center">от</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+5</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">до</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+9</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">средняя степень</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center bg-green-500">&nbsp;</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">Салатовая зона</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-700 px-2 py-2 text-center">от</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+10</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">до</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">+20</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">высокая степень</td>
                                    <td class="border border-gray-700 px-2 py-2 text-center bg-green-800"></td>
                                    <td class="border border-gray-700 px-2 py-2 text-center">Зеленая зона</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">Критерий успеха в жизни и бизнесе – все эмоциональные качества должны быть <span class="text-green-600 font-bold">ЗЕЛЕНЫМИ</span> и больше (+2).</div>
                    <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">РЕКОМЕНДАЦИИ: </div>
                    <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">* Все пункты, представленные в разделе «Здоровье», требуют уточнения и консультации врача. </div>
                    @if($EZ >= -20 && $EZ <= 9)
                        {{-- table for not approved --}}
                        <table class="mx-auto border-collapse border border-gray-700 text-sm mt-5" style="border-width:1px;">
                            <tbody>
                                <tr>
                                    <th class="border border-gray-700 px-2 py-2" style="width:12.5%;">
                                        <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">При степени Эмоциональной зрелости EZ от (-20) до (+9) </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-700 px-2 py-2">
                                        <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">🌿 Ваш тест Кеттелла–Табидзе показал: эмоциональная зрелость нуждается в укреплении</div>
                                        <p class="mt-5">
                                            Это естественно — эмоциональная зрелость формируется постепенно, как навык.
                                            Ваш результат говорит не о слабости, а о точке роста, с которой начинается путь к устойчивости, внутренней уверенности и спокойствию.
                                            Чтобы помочь вам развить эти качества, мы приглашаем на курс по авторской методике профессора А.А. Табидзе:
                                        </p>
                                        <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5"><span class="text-green-700" aria-hidden="true">💚</span>«Стрессоустойчивость и формула счастья для психологов»</div>
                                        <p class="mt-5">
                                            Это естественно — эмоциональная зрелость формируется постепенно, как навык.
                                            Ваш результат говорит не о слабости, а о точке роста, с которой начинается путь к устойчивости, внутренней уверенности и спокойствию.
                                            Чтобы помочь вам развить эти качества, мы приглашаем на курс по авторской методике профессора А.А. Табидзе:
                                        </p>
                                        <p class="mt-5">Курс создан специально для тех, кто хочет:</p>
                                        <ul class="list-disc list-inside mt-2">
                                            <li>перестать зависеть от стрессов и внешнего давления,</li>
                                            <li>научиться управлять своими эмоциями и реакциями,</li>
                                            <li>восстановить внутреннее равновесие и уверенность,</li>
                                            <li>развить зрелые стратегии поведения в сложных ситуациях,</li>
                                        </ul>
                                        <p class="mt-5">Здесь вы:</p>
                                        <ul class="list-disc list-inside mt-2">
                                            <li>шаг за шагом освоите <span class="font-bold">практические инструменты саморегуляции, </span></li>
                                            <li>научитесь <span class="font-bold">сохранять спокойствие под нагрузкой и восстанавливать ресурс без выгорания,</span></li>
                                        </ul>
                                        <p class="mt-5">После прохождения курса вы сможете <span class="font-bold">повторно пройти тест </span>Кеттелла–Табидзе (вариант B) и <span class="font-bold">увидеть, как изменился </span>ваш уровень эмоциональной зрелости — наглядно, в цифрах и ощущениях.</p>
                                        <p class="mt-5">🌿 Это не просто обучение, а путь к <span class="font-bold">внутренней силе, устойчивости и зрелости,</span></p>
                                        <p>которые остаются с вами надолго — в работе, отношениях и жизни.</p>
                                        <p class="mt-5">👉 [Записаться на курс]</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        {{-- table for approved --}}
                        <table class="mx-auto border-collapse border border-gray-700 text-sm mt-5" style="border-width:1px;">
                            <tbody>
                                <tr>
                                    <th class="border border-gray-700 px-2 py-2" style="width:12.5%;">
                                        <div id="c3-title" class="text-xl font-bold text-green-700 mt-5">При значениях степени эмоциональной зрелости EZ = от (+10) до (+20) </div>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="border border-gray-700 px-2 py-2">
                                        <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5">🌿 Поздравляем! Ваш уровень Эмоциональной зрелости впечатляет</div>
                                        <p class="mt-5">
                                            Ваш результат по тесту <span class="font-bold">Кеттелла–Табидзе </span>показал высокий уровень эмоциональной зрелости — редкий и вдохновляющий показатель.
                                            Он говорит о вашей глубокой осознанности, способности управлять эмоциями и сохранять внутреннее равновесие.
                                        </p>
                                        <p class="mt-5">
                                            Но эмоциональная зрелость — не точка, а путь.Чтобы <span class="font-bold">Чтобы укрепить этот навык и подтвердить его официально, </span>
                                            приглашаем вас на курс по авторской методике профессора А.А. Табидзе: 
                                        </p>
                                        <div id="c3-title" class="text-xl font-bold text-gray-900 mt-5"><span class="text-green-700" aria-hidden="true">💚</span>«Стрессоустойчивость и формула счастья для психологов»</div>
                                        <p class="mt-5">Курс для тех, кто уже эмоционально зрел, но хочет:</p>
                                        <ul class="list-disc list-inside mt-2">
                                            <li>укрепить устойчивость под стрессом,</li>
                                            <li>научиться быстро восстанавливаться и беречь свой внутренний ресурс,</li>
                                            <li>управлять эмоциональным состоянием без выгорания,</li>
                                            <li> 
                                                получить <span class="font-bold">Аттестат Эмоциональной Зрелости </span>и быть внесённым в 
                                                <span class="font-bold">Реестр эмоционально зрелых людей России.</span>
                                            </li>
                                        </ul>
                                        <p class="mt-5">Это не просто обучение —</p>
                                        <p>это ваш следующий шаг к <span class="font-bold">внутренней свободе, спокойствию и профессиональному признанию. </span></p>
                                        <p class="mt-5">👉 [Записаться на курс]</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
