<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Data') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add your personal demographic information to personalize test interpretation.') }}
        </p>
    </header>

    <form method="post" action="{{ route('person.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="person_name" :value="__('First Name')" />
            <x-text-input id="person_name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="person_last_name" :value="__('Last Name')" />
            <x-text-input id="person_last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="person_age" :value="__('Age')" />
            <x-text-input id="person_age" name="age" type="number" min="1" max="120" class="mt-1 block w-full" :value="old('age')" required />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <div>
            <x-input-label for="person_gender" :value="__('Gender')" />
            <select id="person_gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>-- {{ __('Select') }} --</option>
                <option value="male" {{ old('gender')==='male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ old('gender')==='female' ? 'selected' : '' }}>{{ __('Female') }}</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('person-created'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
