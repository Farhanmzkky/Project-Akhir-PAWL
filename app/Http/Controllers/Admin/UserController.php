<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::where('role', 'user')->orderBy('name')->paginate(20),
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_unless($user->role === 'user', 403);
        $request->validate(['is_active' => ['required', 'boolean']]);
        $user->is_active = $request->boolean('is_active');
        $user->save();
        return back()->with('notice', 'Status akun diperbarui.');
    }
}
