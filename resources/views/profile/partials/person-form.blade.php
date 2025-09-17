@php
    $person = auth()->user()->people()->first();
    $isEdit = (bool) $person;
    $requiredWarning = session('person_required');
    $errorBorder = $requiredWarning ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Data') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ $isEdit ? __('Update your personal information.') : __('Complete your personal information to continue using the application.') }}
        </p>
        @if($requiredWarning)
            <div class="mt-4 p-4 rounded bg-red-600 text-white text-sm flex items-start gap-3 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.518 11.598c.75 1.336-.213 3.003-1.742 3.003H3.48c-1.53 0-2.492-1.667-1.743-3.003L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a.75.75 0 01-.75-.75V8a.75.75 0 011.5 0v2.25A.75.75 0 0110 11z" clip-rule="evenodd" />
                </svg>
                <span>{{ __('You must complete your personal information before you can navigate through the application.') }}</span>
            </div>
        @endif
    </header>

    <form method="POST" action="{{ $isEdit ? route('person.update', $person) : route('person.store') }}" class="mt-6 space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="name" :value="__('First Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full {{ $errorBorder }}" :value="old('name', $person->name ?? '')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full {{ $errorBorder }}" :value="old('last_name', $person->last_name ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" name="age" type="number" min="1" max="120" class="mt-1 block w-full {{ $errorBorder }}" :value="old('age', $person->age ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $requiredWarning ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" required>
                @php $g = old('gender', $person->gender ?? ''); @endphp
                <option value="" disabled {{ $g === '' ? 'selected' : '' }}>-- Select --</option>
                <option value="male" {{ $g === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ $g === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                <option value="other" {{ $g === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ $isEdit ? __('Save changes') : __('Save data') }}
            </x-primary-button>
            @if (session('status') === 'person-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Data saved.') }}</p>
            @endif
        </div>
    </form>
</section>
