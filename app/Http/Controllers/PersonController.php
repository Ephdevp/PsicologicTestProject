<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user && method_exists($user, 'people') && $user->people()->exists()) {
            return back()->withErrors(['person' => __('Person record already exists.')]);
        }

        $validated = $request->validate([
            'name' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'age' => ['required','integer','min:1','max:120'],
            'gender' => ['required','in:male,female,other'],
        ]);

        $validated['user_id'] = $user->id;

        Person::create($validated);

        return back()->with('status', 'person-updated');
    }

    public function update(Request $request, Person $person)
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user || $person->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'age' => ['required','integer','min:1','max:120'],
            'gender' => ['required','in:male,female,other'],
        ]);

        $person->update($validated);

        return back()->with('status', 'person-updated');
    }
}
