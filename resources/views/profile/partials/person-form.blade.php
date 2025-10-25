@php
    $person = auth()->user()->people()->first();
    $isEdit = (bool) $person;
    $requiredWarning = session('person_required');
    $errorBorder = $requiredWarning ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '';
@endphp

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('doc.profile.personal_data') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ $isEdit ? __('doc.profile.update_info') : __('doc.profile.complete_info') }}
        </p>
        @if($requiredWarning)
            <div class="mt-4 p-4 rounded bg-red-600 text-white text-sm flex items-start gap-3 shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l6.518 11.598c.75 1.336-.213 3.003-1.742 3.003H3.48c-1.53 0-2.492-1.667-1.743-3.003L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a.75.75 0 01-.75-.75V8a.75.75 0 011.5 0v2.25A.75.75 0 0110 11z" clip-rule="evenodd" />
                </svg>
                <span>{{ __('doc.profile.must_complete_warning') }}</span>
            </div>
        @endif
    </header>

    <form method="POST" action="{{ $isEdit ? route('person.update', $person) : route('person.store') }}" class="mt-6 space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div>
            <x-input-label for="name" :value="__('doc.profile.first_name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full {{ $errorBorder }}" :value="old('name', $person->name ?? '')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('doc.profile.last_name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full {{ $errorBorder }}" :value="old('last_name', $person->last_name ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="birthdate" :value="__('doc.profile.birthdate')" />
            <x-text-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full {{ $errorBorder }}" :value="old('birthdate', $person->birthdate ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('birthdate')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('doc.profile.gender')" />
            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 {{ $requiredWarning ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" required>
                @php $g = old('gender', $person->gender ?? ''); @endphp
                <option value="" disabled {{ $g === '' ? 'selected' : '' }}>-- Select --</option>
                    <option value="мужчина" {{ in_array($g, ['male','мужчина']) ? 'selected' : '' }}>{{ __('doc.profile.male') }}</option>
                    <option value="женщина" {{ in_array($g, ['female','женщина']) ? 'selected' : '' }}>{{ __('doc.profile.female') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('doc.profile.phone')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $person->phone ?? '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="education_level" :value="__('doc.profile.education')" />
            @php $el = old('education_level', $person->education_level ?? ''); @endphp
            <select id="education_level" name="education_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="" disabled {{ $el === '' ? 'selected' : '' }}>-- Select --</option>
                    <option value="средняя школа" {{ in_array($el, ['secondary school','secundaria','средняя школа']) ? 'selected' : '' }}>{{ __('doc.education.secondary_school') }}</option>
                    <option value="старшая школа" {{ in_array($el, ['high school','bachillerato','старшая школа']) ? 'selected' : '' }}>{{ __('doc.education.high_school') }}</option>
                    <option value="высшее образование" {{ in_array($el, ['university education','educasion universitaria','высшее образование']) ? 'selected' : '' }}>{{ __('doc.education.university') }}</option>
                    <option value="магистр" {{ in_array($el, ["master's degree","maestria","магистр"]) ? 'selected' : '' }}>{{ __('doc.education.masters') }}</option>
                    <option value="доктор" {{ in_array($el, ['doctorate','doctorado','доктор']) ? 'selected' : '' }}>{{ __('doc.education.doctorate') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('education_level')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ $isEdit ? __('doc.profile.save_changes') : __('doc.profile.save_data') }}
            </x-primary-button>
            @if (session('status') === 'person-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('doc.profile.data_saved') }}</p>
            @endif
        </div>
    </form>
</section>
