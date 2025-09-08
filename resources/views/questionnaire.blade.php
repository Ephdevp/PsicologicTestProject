<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questionnaire') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @for ($i = 1; $i <= 10; $i++)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                    <div class="bg-white border border-gray-300 shadow-md rounded-lg">
                        <div class="p-6">
                            <form action="" method="POST">
                                @csrf
                                <p class="block text-lg font-semibold text-gray-800 mb-4">
                                    {{ __('Question ') . $i }}
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="question{{ $i }}" value="Answer 1" class="form-radio h-5 w-5 text-indigo-600">
                                        <span class="text-gray-700">{{ __('Answer 1') }}</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="question{{ $i }}" value="Answer 2" class="form-radio h-5 w-5 text-indigo-600">
                                        <span class="text-gray-700">{{ __('Answer 2') }}</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="question{{ $i }}" value="Answer 3" class="form-radio h-5 w-5 text-indigo-600">
                                        <span class="text-gray-700">{{ __('Answer 3') }}</span>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endfor
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 shadow-md">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
