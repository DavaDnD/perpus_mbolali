<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\cache;

class UserController extends Controller
{
    // index: normal view OR AJAX (mengembalikan partial rows + pagination)
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rows' => view('admin.users.partials.rows', compact('users'))->render(),
                'pagination' => view('admin.users.partials.pagination', compact('users'))->render(),
                'total' => $users->total()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }


    // show single (JSON) - used to prefill edit form
    public function show(User $user)
    {
        return response()->json($user);
    }

    // store new user (only Officer/Admin via middleware)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
            'role' => ['required', Rule::in(['Admin','Officer','Member'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json(['message' => 'User created', 'user' => $user]);
    }

    // update user
    public function update(Request $request, User $user)
    {
        // Prevent admin from demoting themselves
        if ($user->id === auth()->id() && $request->role !== $user->role && $user->role === 'Admin') {
            return response()->json(['error' => 'You cannot remove your own Admin role.'], 422);
        }

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['Admin','Officer','Member'])],
            'password' => ['nullable','string','min:8','confirmed'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json(['message' => 'User updated', 'user' => $user]);
    }

    // delete single user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete yourself.']);
        }

        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // bulk delete (ids[] array)
    public function destroySelected(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'No users selected.'], 422);
        }

        if (in_array(auth()->id(), $ids)) {
            return response()->json(['error' => 'You cannot delete yourself.'], 422);
        }

        User::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Selected users deleted.']);
    }

    public function onlineStatus()
    {
        $users = User::all();
        $status = [];

        foreach ($users as $user) {
            $status[$user->id] = $user->isOnline();
        }

        return response()->json($status);
    }
}
