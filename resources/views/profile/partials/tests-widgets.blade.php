

<section>
    <header class="mb-4">
    <h2 class="text-lg font-medium text-gray-900">{{ __('doc.tests.overview_title') }}</h2>
    <p class="mt-1 text-sm text-gray-600">{{ __('doc.tests.overview_subtitle') }}</p>
    </header>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="p-5 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-lg shadow flex flex-col">
            <h3 class="text-base font-semibold mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4m0-4a5 5 0 005-5V5a3 3 0 10-6 0v7a5 5 0 005 5" />
                </svg>
                {{ __('doc.tests.available') }}
            </h3>
            <ul class="space-y-3 text-sm flex-1">
                @forelse($available as $t)
                    <li class="bg-white/10 backdrop-blur-sm rounded px-3 py-2">
                        <p class="font-medium">{{ $t['name'] }}</p>
                        <p class="text-white/80">{{ $t['description'] == null ? __('doc.tests.no_description') : $t['description'] }}</p>
                    </li>
                @empty
                    <li class="text-white/80 italic">{{ __('doc.tests.none_available') }}</li>  
                @endforelse
            </ul>
            <div class="mt-4 flex gap-2" data-buy-widget>
                <a href="{{route('dashboard.index')}}" class="inline-flex items-center justify-center px-3 py-2 bg-white/20 hover:bg-white/30 text-sm font-medium rounded-md transition w-full">
                    {{ __('doc.nav.view_all') }}
                </a>
                <button data-buy-open type="button" class="inline-flex items-center justify-center px-3 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold rounded-md shadow transition w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="2" y="7" width="20" height="10" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                        <rect x="6" y="15" width="6" height="2" rx="1" fill="currentColor"/>
                        <line x1="2" y1="11" x2="22" y2="11" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <span class="ms-2">{{ __('doc.nav.buy_more_tests') }}</span>
                </button>
                
                <!-- Buy modal (hidden, scoped to widget) -->
                <div data-buy-modal class="fixed inset-0 z-40 hidden px-4 py-6">
                    <div class="fixed inset-0 bg-black/50 transition-opacity z-40" data-buy-backdrop></div>
                    <div class="flex items-center justify-center min-h-full">
                        <div class="bg-white rounded-lg shadow-lg max-w-md w-full z-50 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">{{ __('doc.nav.buy_more_tests') }}</h3>
                                <button type="button" data-buy-close class="text-gray-500 hover:text-gray-700">&times;</button>
                            </div>
                            <div class="p-4">
                                <p class="text-sm text-gray-600 mb-4">Выберите версию теста для покупки:</p>
                                <div class="grid gap-3">
                                    {{-- implementar link para enviar la informacion a la api de pago --}}
                                    <a href="#" data-buy-action="basic" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-800 rounded-md">{{__('Купить базовый тест')}}</a>  
                                    <a href="#" data-buy-action="premium" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-semibold rounded-md">{{__('Купить тест премиум')}}</a>
                                </div>
                            </div>
                            <div class="p-4 border-t border-gray-100 text-right">
                                <button type="button" data-buy-close class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-md">{{ __('закрыть') }}</button>  </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>

        <div class="p-5 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
            <h3 class="text-base font-semibold mb-3 flex items-center gap-2 text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm3.707 6.293l-4 4a1 1 0 01-1.414 0l-2-2 1.414-1.414L9 10.586l3.293-3.293 1.414 1.414z" />
                </svg>
                {{ __('doc.tests.completed') }}
            </h3>
            <ul class="space-y-3 text-sm flex-1">
                @forelse($completed as $t)
                    <li class="rounded border border-gray-100 px-3 py-2">
                        <a href="{{ route('results.show', ['test' => $t->id]) }}" class="group block -mx-3 -my-2 px-3 py-2 rounded transition-colors duration-200 hover:bg-green-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-green-500">
                            <p class="font-medium text-gray-900 group-hover:text-white">{{ $t->name }}</p>
                            <p class="text-gray-600 text-xs mt-0.5 group-hover:text-white">{{ $t->category }}</p>
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500 italic">{{ __('doc.tests.none_completed') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (function(){
        function lockBody(lock) {
            document.body.style.overflow = lock ? 'hidden' : '';
        }

        document.querySelectorAll('[data-buy-widget]').forEach(widget => {
            const openBtn = widget.querySelector('[data-buy-open]');
            const modal = widget.querySelector('[data-buy-modal]');
            const backdrop = widget.querySelector('[data-buy-backdrop]');
            const closeButtons = widget.querySelectorAll('[data-buy-close]');
            const actionLinks = widget.querySelectorAll('[data-buy-action]');

            if(!openBtn || !modal) return;

            function open() {
                modal.classList.remove('hidden');
                lockBody(true);
                document.addEventListener('keydown', escHandler);
            }

            function close() {
                modal.classList.add('hidden');
                lockBody(false);
                document.removeEventListener('keydown', escHandler);
            }

            function escHandler(e) {
                if (e.key === 'Escape') close();
            }

            openBtn.addEventListener('click', open);
            if(backdrop) backdrop.addEventListener('click', close);
            closeButtons.forEach(b => b.addEventListener('click', close));

        });
    })();
</script>
@endpush
