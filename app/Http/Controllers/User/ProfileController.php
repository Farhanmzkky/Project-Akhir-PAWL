<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController
{
    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:255', 'Rule' => Rule::unique('users')->ignore($user)],
        ]);
        $user->update($data);
        return back()->with('notice', 'Profil berhasil diperbarui.');
    }
}
