<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Test list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <a href="{{route('questionnaire')}}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2 shadow">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    {{ __("Test 1") }}
                    <span class="ml-2 text-sm text-gray-500">0/185</span>
                </div>
            </div>
        </div>
        </a>
        <a href="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2 shadow">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        {{ __("Test 2") }}
                        <span class="ml-2 text-sm text-gray-500">0/185</span>
                    </div>
                </div>
            </div>
        </a>
        <a href="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2 shadow">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        {{ __("Test 3") }}
                        <span class="ml-2 text-sm text-gray-500">0/185</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</x-app-layout>
